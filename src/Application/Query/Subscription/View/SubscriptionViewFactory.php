<?php

namespace App\Application\Query\Subscription\View;

use App\Domain\Subscription\Entity\Subscription;

class SubscriptionViewFactory implements SubscriptionViewFactoryInterface
{

    public function createBasicView(Subscription $subscription): SubscriptionViewInterface
    {

        return new SubscriptionView(
            id: $subscription->getId()->getId(),
            name: $subscription->getName(),
            descirption: $subscription->getDescription(),
            price: $subscription->getPrice(),
            duration: $subscription->getDuration()
        );
    }

}