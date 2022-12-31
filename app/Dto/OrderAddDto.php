<?php

declare(strict_types=1);

namespace App\Dto;

use App\Enums\OrderStatus;

class OrderAddDto
{

    public function __construct(
        public readonly int $amount,
        public readonly OrderStatus $status
    )
    {
    }
}