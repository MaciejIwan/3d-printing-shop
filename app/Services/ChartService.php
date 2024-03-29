<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\OrderAddDto;
use App\Entity\PrintingModel;
use App\Entity\ShoppingCartItem;
use App\Entity\User;
use App\Enum\OrderStatus;
use App\Exceptions\OrderPleaceException;
use Doctrine\ORM\EntityManager;
use http\Exception\InvalidArgumentException;

class ChartService
{
    public function __construct(private readonly EntityManager $entityManager,
                                private readonly OrderService  $orderService)
    {
    }

    public function create(int $printingModelId, int $quantity, User $user): ShoppingCartItem
    {
        $chart = new ShoppingCartItem();

        $printingModel = $this->entityManager->getRepository(PrintingModel::class)->findOneBy(['id' => $printingModelId]);
        $chart
            ->setUser($user)
            ->setQuantity($quantity)
            ->setPrintingModel($printingModel);

        $this->entityManager->persist($chart);
        $this->entityManager->flush();

        return $chart;
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

    public function update(ShoppingCartItem $chart, int $quantity): ShoppingCartItem
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException("Quantity have to bigger or equal 0!. To delete use delete()");
        }

        $chart->setQuantity($quantity);

        $this->entityManager->persist($chart);
        $this->entityManager->flush();

        return $chart;
    }

    public function clearChart(User $user): void
    {
        $chartItemRepository = $this->entityManager->getRepository(ShoppingCartItem::class);
        $query = $chartItemRepository->createQueryBuilder('c')
            ->delete()
            ->where('c.user = :user')
            ->setParameter('user', $user)
            ->getQuery();

        $query->execute();

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function sumbit(User $user)
    {
        $chartItems = $user->getShoppingCardItems();

        if ($chartItems->count() == 0)
            throw new OrderPleaceException("You have to pass at least one item");

        $newOrderDto = new OrderAddDto('Order for ' . $user->getName(), 0, OrderStatus::UNPAID, $user);
        $order = $this->orderService->create($newOrderDto);

        $this->orderService->addOrderItemsFromChart($order, $chartItems);

        return $order;
    }
}
