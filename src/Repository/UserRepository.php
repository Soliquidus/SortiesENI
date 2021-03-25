<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findOneByMail($email)
    {
        return $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.email =' . $email)
            ->getQuery()
            ->execute();
    }

    public function findOneByLastCampusName($campus)
    {
        return $this->createQueryBuilder('u')
            ->select('u.campus')
            ->where('u.campus =' . $campus)
            ->getQuery()
            ->execute();
    }

}
