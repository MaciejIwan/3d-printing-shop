<?php

declare(strict_types=1);

namespace App\Enum;

enum DeliveryType: int
{
    case ToDoor = 0;
    case ToParcelLocker = 1;
    case ToPickupPoint = 2;
    case Pickup = 3;

    public function toString(): string
    {
        return match ($this) {
            self::ToDoor => 'ToDoor',
            self::ToParcelLocker => 'ToParcelLocker',
            self::ToPickupPoint => 'ToPickupPoint',
            default => 'Pending'
        };
    }
}