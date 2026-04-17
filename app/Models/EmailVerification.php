<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    protected $fillable = [
        'email',
        'token',
        'type',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    // Verification types
    const TYPE_REGISTRATION = 'registration';

    const TYPE_UPDATE_PROFILE = 'update_profile';

    const TYPE_UPDATE_PASSWORD = 'update_password';

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }
}
