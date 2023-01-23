<?php

declare(strict_types=1);

namespace App\Enum;

use ReflectionClass;

enum OrderStatus: int
{
    case UNPAID = 0;
    case PENDING = 1;
    case PAID = 2;
    case CANCELED = 3;
    case TO_PICK_UP = 4;
    case IS_PRINTING = 5;

    public function toString(): string
    {
        return match ($this) {
            self::UNPAID => 'unpaid',
            self::PENDING => 'pending',
            self::PAID => 'paid',
            self::CANCELED => 'canceled',
            self::TO_PICK_UP => 'to pick up',
            self::IS_PRINTING => 'is printing',
        };
    }

    public static function fromString(string $value): ?OrderStatus
    {
        $class = new ReflectionClass(OrderStatus::class);
        $constants = $class->getConstants();
        foreach ($constants as $constant) {
            if (strtolower($constant->toString()) === strtolower($value)) {
                return $constant;
            }
        }
        return null;
    }

}
