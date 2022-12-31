<?php

namespace App\Services;


use App\Contracts\UserInterface;
use App\Contracts\UserProviderServiceInterface;
use App\Dto\UserRegisterDto;
use App\Entity\User;
use App\Repository\UserRepository;

class UserService implements UserProviderServiceInterface
{

    public function __construct(private readonly UserRepository $userRepository)
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

    public function createUser(UserRegisterDto $userData): ?UserInterface
    {
        $newUser = $this->buildUserFromFormData($userData);
        $this->userRepository->add($newUser);

        return $newUser;
    }

    public function buildUserFromFormData(UserRegisterDto $userData): User
    {
        $newUser = new User();
        $password_hash = password_hash($userData->password, PASSWORD_BCRYPT, ['cost' => 12]);
        $newUser
            ->setName($userData->name)
            ->setEmail($userData->email)
            ->setPasswordHash($password_hash);
        return $newUser;
    }


}