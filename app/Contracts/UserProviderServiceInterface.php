<?php

declare(strict_types=1);

namespace App\Contracts;


use App\Dto\UserRegisterDto;

interface UserProviderServiceInterface
{
    public function getById(int $userId): ?UserInterface;

    public function getByCredentials(array $credentials): ?UserInterface;

    public function createUser(UserRegisterDto $userData): ?UserInterface;
}
