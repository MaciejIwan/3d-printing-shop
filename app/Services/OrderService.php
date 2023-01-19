<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\OrderAddDto;
use App\Entity\Order;
use App\Entity\OrderItem;
use Doctrine\Common\Collections\Collection;
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
        $order->setTotal($dto->amount);
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

    public function addOrderItemsFromChart(Order $order, Collection $chartItems): void
    {
        $total = 0;
        foreach ($chartItems as $chartItem) {
            $orderItem = new OrderItem();
            $orderItem->setPrintingModel($chartItem->getPrintingModel());
            $orderItem->setQuantity($chartItem->getQuantity());
            $orderItem->setUnitPrice($chartItem->getPrintingModel()->getPrice());
            $order->addItem($orderItem);
            $total += $chartItem->getPrintingModel()->getPrice() * $chartItem->getQuantity();
        }
        $order->setTotal($total);

        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }
}
