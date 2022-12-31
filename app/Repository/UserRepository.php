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


    public function add(User $new_user)
    {
        $this->getEntityManager()->persist($new_user);
        $this->getEntityManager()->flush();
    }

    public function isEmailTaken(string $email): bool
    {
        return boolval($this->count(['email' => $email]));
    }

}