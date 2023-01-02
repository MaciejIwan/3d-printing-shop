<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Category;
use App\Entity\User;
use App\Enum\OrderStatus;
use Doctrine\ORM\EntityManager;

class OrderService
{
    public function __construct(private readonly EntityManager $entityManager)
    {
    }

    public function create(string $name, User $user): Category
    {
        $category = new Category();

        $category->setUser($user);
        $category->setStatus(OrderStatus::New);

        return $this->update($category, $name);
    }

    public function getAll(): array
    {
        return $this->entityManager->getRepository(Category::class)->findAll();
    }

    public function delete(int $id): void
    {
        $category = $this->entityManager->find(Category::class, $id);

        $this->entityManager->remove($category);
        $this->entityManager->flush();
    }

    public function getById(int $id): ?Category
    {
        return $this->entityManager->find(Category::class, $id);
    }

    public function update(Category $category, string $name): Category
    {
        $category->setName($name);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $category;
    }
}
