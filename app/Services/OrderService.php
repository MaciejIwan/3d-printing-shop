<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\OrderAddDto;
use App\Entity\Order;
use App\Repository\OrderRepository;

class OrderService
{
    public function __construct(private readonly OrderRepository $orderRepository)
    {

    }

    public function create(OrderAddDto $param): Order
    {
        $order = (new Order())
            ->setAmount($param->amount)
            ->setStatus($param->status);
        $this->orderRepository->add($order);

        return $order;
    }
}