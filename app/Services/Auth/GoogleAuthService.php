<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Tymon\JWTAuth\Facades\JWTAuth;

class GoogleAuthService
{
    /**
     * @param  string  $idToken  Google ID Token (JWT)
     * @param  string|null  $accessToken  Optional Google OAuth Access Token
     * @return array{user:\App\Models\User, token:string}
     */
    public function loginWithGoogle(string $idToken, ?string $accessToken = null): array
    {
        // 1) Verify id_token ke Google
        $tokenInfo = $this->verifyIdToken($idToken);
        if (! $tokenInfo || ! filter_var(Arr::get($tokenInfo, 'email'), FILTER_VALIDATE_EMAIL)) {
            throw new \RuntimeException('Invalid Google token.');
        }
        if (! $this->isEmailVerified($tokenInfo)) {
            throw new \RuntimeException('Google email is not verified.');
        }

        // 2) Ambil profile dari payload id_token (decode) + (opsional) userinfo API
        $claims = $this->decodeJwtPayload($idToken); // tidak untuk verifikasi; hanya ekstrak claim
        $profile = [
            'sub' => Arr::get($tokenInfo, 'sub') ?: Arr::get($claims, 'sub'),
            'email' => Arr::get($tokenInfo, 'email') ?: Arr::get($claims, 'email'),
            'name' => Arr::get($claims, 'name'),
            'given_name' => Arr::get($claims, 'given_name'),
            'family_name' => Arr::get($claims, 'family_name'),
            'picture' => Arr::get($claims, 'picture'),
        ];

        // Jika masih kurang (name/picture kosong) dan access_token tersedia → fetch userinfo
        if ($accessToken && (empty($profile['name']) || empty($profile['picture']))) {
            if ($ui = $this->fetchUserInfo($accessToken)) {
                $profile['name'] = $profile['name'] ?: Arr::get($ui, 'name');
                $profile['given_name'] = $profile['given_name'] ?: Arr::get($ui, 'given_name');
                $profile['family_name'] = $profile['family_name'] ?: Arr::get($ui, 'family_name');
                $profile['picture'] = $profile['picture'] ?: Arr::get($ui, 'picture');
            }
        }

        // Pastikan ada nilai name
        if (empty($profile['name'])) {
            $profile['name'] = $this->fallbackName($profile['email'], $profile['given_name'] ?? null, $profile['family_name'] ?? null);
        }

        // 3) Temukan / tautkan user (LINK behavior)
        $user = $this->findOrLinkUser($profile);

        // 4) Generate JWT
        $token = JWTAuth::fromUser($user);

        return ['token' => $token, 'user' => $user, 'refresh_token' => null];
    }

    /** ----- Helpers ----- */
    private function verifyIdToken(string $idToken): ?array
    {
        \Log::info('Verifying ID token with Google', ['token_length' => strlen($idToken)]);

        $r = Http::get('https://oauth2.googleapis.com/tokeninfo', ['id_token' => $idToken]);

        \Log::info('Google tokeninfo response', [
            'status' => $r->status(),
            'body' => $r->json(),
        ]);

        return $r->ok() ? $r->json() : null;
    }

    private function isEmailVerified(array $tokenInfo): bool
    {
        $ev = Arr::get($tokenInfo, 'email_verified');

        // tokeninfo kadang string "true"/"false"
        return $ev === true || $ev === 'true' || $ev === 1 || $ev === '1';
    }

    private function fetchUserInfo(string $accessToken): ?array
    {
        $r = Http::withToken($accessToken)
            ->get('https://www.googleapis.com/oauth2/v3/userinfo');

        return $r->ok() ? $r->json() : null;
    }

    /**
     * Decode payload JWT tanpa verifikasi (verifikasi sudah dilakukan via tokeninfo).
     */
    private function decodeJwtPayload(string $jwt): array
    {
        $parts = explode('.', $jwt);
        if (count($parts) < 2) {
            return [];
        }
        $payload = $parts[1];
        $payload .= str_repeat('=', (4 - strlen($payload) % 4) % 4); // pad
        $json = base64_decode(strtr($payload, '-_', '+/')) ?: '';

        return $json ? (json_decode($json, true) ?: []) : [];
    }

    private function fallbackName(?string $email, ?string $given = null, ?string $family = null): string
    {
        if ($given || $family) {
            return trim(($given ?? '').' '.($family ?? '')) ?: 'Google User';
        }
        if ($email) {
            return ucfirst(str_replace(['.', '_', '-'], ' ', explode('@', $email)[0]));
        }

        return 'Google User';
    }

    private function findOrLinkUser(array $p): User
    {
        // Cari by google_id dulu
        $user = null;
        if (! empty($p['sub'])) {
            $user = User::where('google_id', $p['sub'])->first();
        }

        // Kalau belum ada, coba by email (LINK behavior)
        if (! $user && ! empty($p['email'])) {
            $user = User::where('email', $p['email'])->first();
        }

        if ($user) {
            // Lengkapi hanya yang kosong — tidak overwrite data existing
            $changed = false;

            if (empty($user->google_id) && ! empty($p['sub'])) {
                $user->google_id = $p['sub'];
                $changed = true;
            }
            if (empty($user->avatar) && ! empty($p['picture'])) {
                $user->avatar = $p['picture'];
                $changed = true;
            }
            if (empty($user->name) && ! empty($p['name'])) {
                $user->name = $p['name'];
                $changed = true;
            }
            if (empty($user->username)) {
                $user->username = $this->generateUsername($p['name'] ?: $user->name ?: $p['email'] ?? null);
                $changed = true;
            }

            if ($changed) {
                $user->save();
            }

            return $user;
        }

        // User belum ada → create baru
        $user = User::create([
            'name' => $p['name'] ?? 'Google User',
            'email' => $p['email'] ?? null,
            'username' => $this->generateUsername($p['name'] ?? ($p['email'] ?? null)),
            'google_id' => $p['sub'] ?? null,
            'avatar' => $p['picture'] ?? null,
            'email_verified_at' => now(),
            'password' => bcrypt(str()->random(32)),
        ]);

        // Assign owner role for new users
        if (method_exists($user, 'assignRole')) {
            $user->assignRole('owner');
        }

        return $user;
    }

    private function generateUsername(?string $seed): string
    {
        if (! $seed) {
            return 'user'.time();
        }

        // basis dari nama atau local-part email
        $base = strtolower(trim($seed));
        if (str_contains($base, '@')) {
            $base = explode('@', $base)[0];
        }
        // ubah spasi/simbol jadi dot
        $base = preg_replace('/[^a-z0-9]+/i', '.', $base);
        $base = trim($base, '.');
        if ($base === '') {
            $base = 'user';
        }

        $candidate = $base;
        $i = 1;
        while (User::where('username', $candidate)->exists()) {
            $candidate = $base.$i;
            $i++;
        }

        return $candidate;
    }
}
