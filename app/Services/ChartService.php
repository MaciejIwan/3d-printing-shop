<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\ShoppingCartItem;
use App\Entity\User;
use Doctrine\ORM\EntityManager;

class ChartService
{
    public function __construct(private readonly EntityManager    $entityManager)
    {
    }

    public function create(string $name, User $user): ShoppingCartItem
    {
        $chart = new ShoppingCartItem();

        $chart->setUser($user);

        return $this->update($chart);
    }

    public function getAll(): array
    {
        return $this->entityManager->getRepository(ShoppingCartItem::class)->findAll();
    }

    public function delete(int $id): void
    {
        $chart = $this->entityManager->find(ShoppingCartItem::class, $id);

        $this->entityManager->remove($chart);
        $this->entityManager->flush();
    }

    public function getById(int $id): ?ShoppingCartItem
    {
        return $this->entityManager->find(ShoppingCartItem::class, $id);
    }

    public function update(ShoppingCartItem $chart): ShoppingCartItem
    {

        $this->entityManager->persist($chart);
        $this->entityManager->flush();

        return $chart;
    }
}
