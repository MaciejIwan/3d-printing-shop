<?php

namespace App\Enum;

use ReflectionClass;

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

    public static function fromString(string $value): ?UserRole
    {
        $class = new ReflectionClass(UserRole::class);
        $constants = $class->getConstants();
        foreach ($constants as $constant) {
            if (strtolower($constant->toString()) === strtolower($value)) {
                return $constant;
            }
        }
        return null;
    }
}
