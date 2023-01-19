<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\UserInterface;
use App\Contracts\UserProviderServiceInterface;
use App\Dto\RegisterUserData;
use App\Dto\UserUpdateDto;
use App\Entity\User;
use Doctrine\ORM\EntityManager;

class UserProviderService implements UserProviderServiceInterface
{
    public function __construct(private readonly EntityManager $entityManager)
    {
    }

    public function getById(int $userId): ?UserInterface
    {
        return $this->entityManager->find(User::class, $userId);
    }

    public function getByCredentials(array $credentials): ?UserInterface
    {
        return $this->entityManager->getRepository(User::class)->findOneBy(['email' => $credentials['email']]);
    }

    public function createUser(RegisterUserData $data): UserInterface
    {
        $user = new User();

        $user->setName($data->name);
        $user->setEmail($data->email);
        $user->setRole($data->userRole);
        $user->setPassword(password_hash($data->password, PASSWORD_BCRYPT, ['cost' => 12]));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function getAllUsers(): array
    {
        return $this->entityManager->getRepository(User::class)->findAll();
    }

    public function delete(int $id)
    {
        $category = $this->entityManager->find(User::class, $id);

        $this->entityManager->remove($category);
        $this->entityManager->flush();
    }

    public function update(User $user, UserUpdateDto $data): User
    {
        //todo allow to change password
        $user->setName($data->name);
        $user->setEmail($data->email);

        //$this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

}
