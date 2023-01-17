<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\OrderAddDto;
use App\Entity\Order;
use App\Entity\User;
use App\Enum\OrderStatus;
use Doctrine\ORM\EntityManager;

class OrderService
{
    public function __construct(private readonly EntityManager $entityManager)
    {
    }

    public function create(OrderAddDto $dto): Order
    {
        $order = new Order();

        $order->setUser($dto->user);
        $order->setAmount($dto->amount);
        $order->setStatus($dto->status);

        return $this->update($order, $dto->name);
    }

    public function getAll(): array
    {
        return $this->entityManager->getRepository(Order::class)->findAll();
    }

    public function delete(int $id): void
    {
        $order = $this->entityManager->find(Order::class, $id);

        $this->entityManager->remove($order);
        $this->entityManager->flush();
    }

    public function getById(int $id): ?Order
    {
        return $this->entityManager->find(Order::class, $id);
    }

    public function update(Order $order, string $name): Order
    {
        $order->setName($name);

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $order;
    }
}
