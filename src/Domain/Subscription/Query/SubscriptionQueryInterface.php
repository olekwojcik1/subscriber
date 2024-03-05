<?php

namespace App\Domain\Subscription\Query;

use App\Domain\Subscription\Entity\Subscription;

interface SubscriptionQueryInterface
{
    public function findAll(): array;
    public function findOneById(string $id): Subscription;
}