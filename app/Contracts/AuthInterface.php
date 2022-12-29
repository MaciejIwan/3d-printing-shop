<?php

namespace App\Contracts;

use App\Dto\UserRegisterDto;

interface AuthInterface
{

    public function user(): ?UserInterface;

    public function attemptLogin(array $credentials): bool;

    public function checkCredentials(UserInterface $user, array $credentials): bool;

    public function logOut(): void;
    public function logIn(UserInterface $user): void;
    public function register(UserRegisterDto $data): UserInterface;
}