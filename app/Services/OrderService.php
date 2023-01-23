<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\OrderAddDto;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\User;
use App\Enum\OrderStatus;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;

class OrderService
{
    public function __construct(
        private readonly EntityManager $entityManager,
    )
    {
    }

    public function create(OrderAddDto $dto): Order
    {
        $order = new Order();

        $order->setUser($dto->user);
        $order->setTotal($dto->amount);
        $order->setStatus($dto->status);

        return $this->update($order, $dto->name, $order->getStatus(), $order->isPaid());
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

    public function update(Order $order, string $name, OrderStatus $status, bool $isPaid): Order
    {
        $order->setName($name);
        $order->setStatus($status);
        $order->setPaid($isPaid);

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

    public function getAllByUser(User $user): array
    {
        return $this->entityManager->getRepository(Order::class)->findBy(['user' => $user]);
    }

    public function updatePaymentSession(Order $order, string $paymentId, string $payment_status)
    {
        $order->setPaymentId($paymentId);
        if ($payment_status == 'paid') {
            $order->setPaid(true);
            $order->setStatus(OrderStatus::PENDING);
        }

        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }

    public function getByPaymentId(string $session_id): Order
    {
        return $this->entityManager->getRepository(Order::class)->findOneBy(['paymentId' => $session_id]);
    }
}
