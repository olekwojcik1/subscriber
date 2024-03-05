<?php

namespace App\Domain\Subscription\Repository;

use App\Domain\Subscription\Entity\Subscription;

interface SubscriptionRepositoryInterface
{
    public function save(Subscription $subscription): void;

}