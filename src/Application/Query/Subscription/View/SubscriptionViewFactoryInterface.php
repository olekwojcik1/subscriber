<?php

namespace App\Application\Query\Subscription\View;

use App\Domain\Subscription\Entity\Subscription;

interface SubscriptionViewFactoryInterface
{
    public function createBasicView(Subscription $subscription): SubscriptionViewInterface;
}