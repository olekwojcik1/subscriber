<?php

namespace App\Infrastructure\Doctrine\Repository\Subscription;

use App\Domain\Subscription\Entity\Subscription;
use App\Domain\Subscription\Query\SubscriptionQueryInterface;
use App\Domain\Subscription\Repository\SubscriptionRepositoryInterface;
use App\Infrastructure\Doctrine\Repository\ORM\BaseRepository;

class SubscriptionRepository extends BaseRepository implements SubscriptionQueryInterface, SubscriptionRepositoryInterface
{

    public function findAll(): array
    {
        $qb = $this->_em->createQueryBuilder();
        $q = $qb
            ->select('s')
            ->from(Subscription::class, 's');

        return $q->getQuery()->getResult();
    }

    /**
     * @throws \Exception
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    public function findOneById(string $id): Subscription
    {
        return $this->findById(Subscription::class, $id);
    }

    public function save(Subscription $subscription): void
    {
        $this->saveObj($subscription);
    }

}