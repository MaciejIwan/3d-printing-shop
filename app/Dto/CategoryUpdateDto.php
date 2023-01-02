<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Category;

class CategoryUpdateDto
{


    public function __construct(
        public readonly int    $id,
        public readonly string $name,
    )
    {
    }

    public static function fromArray(array $data): CategoryUpdateDto
    {
        return new static(
            $data['id'],
            $data['name'],
        );
    }

    public static function fromEntity(Category $category): CategoryUpdateDto
    {
        return CategoryUpdateDto::fromArray([
            'id' => $category->getId(),
            'name' => $category->getName()
        ]);
    }
}

