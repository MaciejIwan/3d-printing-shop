<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class UserRepository extends EntityRepository
{

    public function __construct(EntityManager $entityManager)
    {
        $metaData = new ClassMetadata(User::class);
        parent::__construct($entityManager, $metaData);
    }


    public function fetchUser($user_id)
    {
        return $this->find(User::class, $user_id);
    }

}