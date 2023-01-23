<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\User;
use App\Enum\UserRole;

class UserUpdateDto
{
    public function __construct(
        public readonly int      $id,
        public readonly string   $name,
        public readonly string   $email,
        public readonly UserRole $role,
        public readonly string   $created_at,
        public readonly string   $updated_at,
    )
    {
    }

    public static function fromEditForm(array $data): UserUpdateDto
    {
        return new static(
            intval($data['id']),
            $data['name'],
            $data['email'],
            UserRole::fromString($data['role']),
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
            UserRole::fromString($data['role']),
            date('m/d/Y g:i A', $data['created_at']->getTimestamp()),
            date('m/d/Y g:i A', $data['updated_at']->getTimestamp()),
        );
    }

    public static function fromEntity(User $user): UserUpdateDto
    {
        return new static(
            $user->getId(),
            $user->getName(),
            $user->getEmail(),
            $user->getRole(),
            date('m/d/Y g:i A', $user->getCreatedAt()->getTimestamp()),
            date('m/d/Y g:i A', $user->getUpdatedAt()->getTimestamp())
        );
    }

}
