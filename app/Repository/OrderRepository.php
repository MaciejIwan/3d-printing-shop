<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Order;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class OrderRepository extends EntityRepository
{
    public function __construct(EntityManager $entityManager)
    {
        $metaData = new ClassMetadata(Order::class);
        parent::__construct($entityManager, $metaData);
    }
    public function add(Order $order)
    {
        $this->getEntityManager()->persist($order);
        $this->getEntityManager()->flush();
    }
}