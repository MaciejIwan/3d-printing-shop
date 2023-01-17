<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Order;
use App\Entity\User;

class OrderUpdateDto
{
    public function __construct(
        public readonly int    $id,
        public readonly string $name,
        public readonly string $status,
        public readonly string $created_at,
        public readonly string $updated_at,
    )
    {
    }

    public static function fromArray(array $data): OrderUpdateDto
    {
        return new static(
            $data['id'],
            $data['name'],
            $data['status'],
            date('m/d/Y g:i A', $data['created_at']->getTimestamp()),
            date('m/d/Y g:i A', $data['updated_at']->getTimestamp()),
        );
    }

    public static function fromEntity(Order $order): OrderUpdateDto
    {
        return OrderUpdateDto::fromArray([
            'id' => $order->getId(),
            'name' => $order->getName(),
            'status' => $order->getStatus()->toString(),
            'created_at' => $order->getCreatedAt(),
            'updated_at' => $order->getUpdatedAt()
        ]);
    }
}
