<?php

namespace App\Services;


use App\Repository\UserRepository;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository)
    {

    }

    public function getAllUsers(): array
    {
        return $this->userRepository->findAll();
    }
}