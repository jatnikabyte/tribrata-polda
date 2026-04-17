<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class SubscriberController extends Controller
{
    /**
     * Redirect to Google OAuth for subscription.
     */
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Redirect to Google OAuth for specific tabloid subscription.
     */
    public function redirectForTabloid(string $tabloidId): RedirectResponse
    {
        // Store tabloid ID in session for later retrieval in callback
        session(['subscribing_tabloid_id' => $tabloidId]);

        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback.
     */
    public function callback(): RedirectResponse
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Save to subscribers table
        $subscriber = Subscriber::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'subscribed_at' => now(),
                'is_active' => true,
            ]
        );

        // If subscribing for a specific tabloid, create pivot record
        $tabloidId = session('subscribing_tabloid_id');
        if ($tabloidId) {
            try {
                $decryptedId = decrypt($tabloidId);
                // Attach subscriber to tabloid if not already attached
                if (!$subscriber->tabloids()->where('tabloid_id', $decryptedId)->exists()) {
                    $subscriber->tabloids()->attach($decryptedId, ['subscribed_at' => now()]);
                }
            } catch (\Exception $e) {
                // Invalid tabloid ID, just proceed without association
            }
            // Clear the session
            session()->forget('subscribing_tabloid_id');
        }

        // Save in cookie (not session)
        return redirect('/')->cookie(
            'subscriber_email',
            $subscriber->email,
            0,
            '/',
            null,
            true,   // secure (HTTPS only)
            true,   // httpOnly
            false,
            'Lax'
        );
    }
}
