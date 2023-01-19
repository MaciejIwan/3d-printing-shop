<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\ShoppingCartItem;

class ChartUpdateDto
{
    public function __construct(
        public readonly string $name,
        public readonly int    $id,
        public readonly int $quantity
    )
    {
    }

    public static function fromArray(array $data): ChartUpdateDto
    {
        return new static(
            $data['name'],
            $data['id'],
            $data['quantity']
        );
    }

    public static function fromEntity(ShoppingCartItem $item): ChartUpdateDto
    {
        return ChartUpdateDto::fromArray([
            'name'=>$item->getPrintingModel()->getOriginalName(),
            'id' => $item->getId(),
            'quantity' => $item->getQuantity()
        ]);
    }
}

