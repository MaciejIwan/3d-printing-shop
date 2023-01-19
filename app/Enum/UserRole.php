<?php

namespace App\Enum;

enum UserRole: string
{
    case User = 'user';
    case Blocked = 'blocked';
    case Admin = 'admin';

    public function toString(): string
    {
        return match ($this) {
            self::User => 'user',
            self::Blocked => 'blocked',
            self::Admin => 'admin',
        };
    }
}
