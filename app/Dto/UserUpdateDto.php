<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\User;

class UserUpdateDto
{
    public function __construct(
        public readonly int    $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $created_at,
        public readonly string $updated_at,
    )
    {
    }

    public static function fromEditForm(array $data): UserUpdateDto
    {
        return new static(
            intval($data['id']),
            $data['name'],
            $data['email'],
            "",
            ""
        );
    }

    public static function fromArray(array $data): UserUpdateDto
    {
        return new static(
            intval($data['id']),
            $data['name'],
            $data['email'],
            date('m/d/Y g:i A', $data['created_at']->getTimestamp()),
            date('m/d/Y g:i A', $data['updated_at']->getTimestamp()),
        );
    }

    public static function fromEntity(User $user): UserUpdateDto
    {
        return UserUpdateDto::fromArray([
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'created_at' => $user->getCreatedAt(),
            'updated_at' => $user->getUpdatedAt()
        ]);
    }

}