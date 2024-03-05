<?php

namespace App\Infrastructure\Doctrine\Repository\User;

use App\Domain\User\Entity\UserSubscriptions\UserSubscription;
use App\Infrastructure\Doctrine\Repository\ORM\BaseRepository;

class UserSubscriptionRepository extends BaseRepository
{

    public function findAllSubscriptionWhereEnDateIsLowerThenCurrentDate():array{

        $endDate = new \DateTime(); // Your new date time

        $queryBuilder = $this->_em->createQueryBuilder();

        $query = $queryBuilder
            ->select('s')
            ->from(UserSubscription::class, 's')
            ->where($queryBuilder->expr()->lt('s.endDate', ':endDate'))
            ->andWhere('s.stats = :status' )
            ->setParameter('endDate', $endDate)
            ->setParameter('status', 'active')
            ->getQuery();

        return $query->getResult();
    }

}