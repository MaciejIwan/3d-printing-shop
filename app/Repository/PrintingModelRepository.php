<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\PrintingModel;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class PrintingModelRepository extends EntityRepository
{
    public function __construct(EntityManager $entityManager)
    {
        $metaData = new ClassMetadata(PrintingModel::class);
        parent::__construct($entityManager, $metaData);
    }
    public function addPrintingModel(PrintingModel $printingModel)
    {
        $this->getEntityManager()->persist($printingModel);
        $this->getEntityManager()->flush();
    }
}