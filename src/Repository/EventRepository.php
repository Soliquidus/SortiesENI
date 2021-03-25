<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\EventSearch;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * @return QueryBuilder
     */
    public function IndexQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('e')
            ->innerJoin('e.address', 'a')
            ->addSelect('a')
            ->innerJoin('a.city', 'c')
            ->addSelect('c')
            ->innerJoin('e.campus', 'campus')
            ->addSelect('campus')
            ->leftJoin('e.subscriptions', 'subs')
            ->leftJoin('e.creator', 'creator')
            ->addSelect('creator')
            ->addSelect('subs');
    }


    /**
     * @param EventSearch $search
     * @param User $logUser
     * @param bool $ownCreator
     * @param bool $passed
     * @param bool $subscription
     * @param bool $unsubscribed
     * @return int|mixed|string
     */
    public function SearchQuery(
        EventSearch $search,
        User $logUser,
        bool $ownCreator = false,
        bool $passed = false,
        bool $subscription = false,
        bool $unsubscribed = false
    )
    {
        $query = $this->createQueryBuilder('e')
            ->innerJoin('e.address', 'a')
            ->addSelect('a')
            ->innerJoin('a.city', 'c')
            ->addSelect('c')
            ->innerJoin('e.campus', 'campus')
            ->addSelect('campus')
            ->leftJoin('e.subscriptions', 'subs')
            ->addSelect('subs');

        if ($search->getName()) {
            $query = $query
                ->andWhere('e.title LIKE :name')
                ->setParameter('name', '%' . $search->getName() . '%');
        }
        if ($search->getMinDate()) {
            $query = $query
                ->andWhere('e.beginsAt BETWEEN :minDate AND :maxDate')
                ->setParameter('maxDate', $search->getMaxDate())
                ->setParameter('minDate', $search->getMinDate());
        }
        if ($passed == true) {
            $query->andWhere('e.beginsAt <= :passed')
                ->setParameter('passed', date('Y-m-d H:i:s'));
        }
        if ($ownCreator == true) {
            $query->andWhere('e.creator = :creator')
                ->setParameter('creator', $logUser->getId());
        }
        if ($subscription == true) {
            $query->andWhere('subs.subscriber = :subscription')
                ->setParameter('subscription', $logUser->getId());
        }
        if($unsubscribed == true) {
            $query->andWhere('subs.subscriber = :subscription')
                ->setParameter('subscription', $logUser->getId());
        }
        $query = $query->getQuery();
        return $query->execute();
    }

    public function showQuery(int $id)
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->where('e.id =' . $id)
            ->setMaxResults(1)
            ->innerJoin('e.address', 'a')
            ->addSelect('a')
            ->innerJoin('a.city', 'c')
            ->addSelect('c')
            ->leftJoin('e.subscriptions', 'subs')
            ->addSelect('subs')
            ->leftJoin('subs.subscriber', 'sub')
            ->addSelect('sub')
            ->innerJoin('e.creator', 'creator')
            ->addSelect('creator')
            ->getQuery()
            ->execute();
    }


    public function homeQuery()
    {
        return $this->createQueryBuilder('e')
            ->innerJoin('e.address', 'a')
            ->addSelect('a')
            ->innerJoin('a.city', 'c')
            ->addSelect('c')
            ->leftJoin('e.subscriptions', 'subs')
            ->addSelect('subs')
            ->orderBy('e.creationDate', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->execute();
    }


}
