<?php

namespace App\Services;


use App\Contracts\UserInterface;
use App\Contracts\UserProviderServiceInterface;
use App\Repository\UserRepository;

class UserService implements UserProviderServiceInterface
{
    public function __construct(
        private readonly UserRepository $userRepository)
    {

    }

    public function getById(int $userId): ?UserInterface
    {
        return $this->userRepository->find($userId);
    }

    public function getByCredentials(array $credentials): ?UserInterface
    {
        return $this->userRepository->findOneBy(['email' => $credentials['email']]);
    }

    public function getAllUsers(): array
    {
        return $this->userRepository->findAll();
    }
}