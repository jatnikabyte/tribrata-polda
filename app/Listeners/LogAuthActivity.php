<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class LogAuthActivity
{
    public function handleLogin(Login $event): void
    {
        $user = $event->user instanceof User ? $event->user : null;

        activity('authentication')
            ->causedBy($user)
            ->performedOn($user)
            ->event('login')
            ->withProperties([
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'guard' => $event->guard,
                'remember' => $event->remember,
            ])
            ->log('login');
    }

    public function handleLogout(Logout $event): void
    {
        $user = $event->user instanceof User ? $event->user : null;

        activity('authentication')
            ->causedBy($user)
            ->performedOn($user)
            ->event('logout')
            ->withProperties([
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'guard' => $event->guard,
            ])
            ->log('logout');
    }
}
