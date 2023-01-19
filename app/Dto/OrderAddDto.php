<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\User;
use App\Enum\OrderStatus;

class OrderAddDto
{

    public function __construct(
        public readonly string      $name,
        public readonly int         $amount,
        public readonly OrderStatus $status,
        public readonly User        $user
    )
    {
    }

    public static function fromArrayAndUser(array $data, User $user): OrderAddDto
    {
        return new static(
            $data['name'],
            intval($data['amount']),
            OrderStatus::Unpaid,
            $user,
        );
    }
}
