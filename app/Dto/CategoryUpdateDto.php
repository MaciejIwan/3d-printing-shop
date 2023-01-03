<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Category;

class CategoryUpdateDto
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

    public static function fromArray(array $data): CategoryUpdateDto
    {
        return new static(
            $data['id'],
            $data['name'],
            $data['status'],
            date('m/d/Y g:i A', $data['created_at']->getTimestamp()),
            date('m/d/Y g:i A', $data['updated_at']->getTimestamp()),
        );
    }

    public static function fromEntity(Category $category): CategoryUpdateDto
    {
        return CategoryUpdateDto::fromArray([
            'id' => $category->getId(),
            'name' => $category->getName(),
            'status' => $category->getStatus()->toString(),
            'created_at' => $category->getCreatedAt(),
            'updated_at' => $category->getUpdatedAt()
        ]);
    }
}

