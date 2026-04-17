<?php

namespace App\Traits;

use App\Http\Resources\AuthResource;

trait AuthTokenResponse
{
    public function tokenResponse($user, $token, $refresh_token = null)
    {
        return [
            'token' => $token,
            'refresh_token' => $refresh_token,
            'expires_in' => tokenExp(),
            'token_type' => 'Bearer',
            'user' => new AuthResource($user),
        ];
    }
}
