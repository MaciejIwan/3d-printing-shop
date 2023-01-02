<?php

declare(strict_types=1);

namespace App\Enum;

enum OrderStatus: int
{
    case New = 0;
    case Pending = 1;
    case Paid = 2;
    case Canceled = 3;

    public function toString(): string
    {
        return match ($this) {
            self::New => 'New',
            self::Pending => 'Pending',
            self::Paid => 'Paid',
            self::Canceled => 'Canceled'
        };
    }

}