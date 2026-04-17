<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;

class LogFailedLoginAttempt
{
    public function handle(Failed $event): void
    {
        activity('authentication')
            ->causedBy($event->user)
            ->event('failed_login')
            ->withProperties([
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'guard' => $event->guard,
                'attempted_email' => $event->credentials['email'] ?? null,
            ])
            ->log('failed_login');
    }
}
