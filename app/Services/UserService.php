<?php

namespace App\Services;

use App\Entity\User;
use Doctrine\ORM\EntityManager;

class UserService
{
    public function __construct(private EntityManager $entityManager)
    {

    }

    public function getAllUsers(): array
    {
        return $this->entityManager->getRepository(User::class)->findAll();
    }
}