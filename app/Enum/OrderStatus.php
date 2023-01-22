<?php

declare(strict_types=1);

namespace App\Enum;

enum OrderStatus: int
{
    case Unpaid = 0;
    case Pending = 1;
    case Paid = 2;
    case Canceled = 3;
    case ToPickUp = 4;

    public function toString(): string
    {
        return match ($this) {
            self::Unpaid => 'unpaid',
            self::Pending => 'pending',
            self::Paid => 'paid',
            self::Canceled => 'canceled',
            self::ToPickUp => 'to pick up',
        };
    }

}
