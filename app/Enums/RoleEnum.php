<?php

namespace App\Enums;

enum RoleEnum: string
{
    case OWNER = 'owner';
    case CASHIER = 'cashier';
    case ADMIN = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::OWNER => 'Owner',
            self::CASHIER => 'Cashier',
            self::ADMIN => 'Admin',
        };
    }

    public function id(): int
    {
        return match ($this) {
            self::OWNER => 1,
            self::CASHIER => 2,
            self::ADMIN => 3,
        };
    }
}
