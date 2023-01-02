<?php

declare(strict_types=1);

namespace App\Dto;

class RegisterUserData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password
    )
    {
    }
}
