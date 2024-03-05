<?php

namespace App\Application\Query\User\VIew\UserSubscriptionView;

use App\Domain\User\Entity\UserSubscriptions\UserSubscription;

class UserSubscriptionViewFactory implements UserSubscriptionViewFactoryInterface
{

    public function createUserSubscriptionView(UserSubscription $userSubscription): UserSubscriptionViewInterface
    {
        return new UserSubscriptionView(
            id: $userSubscription->getId()->getId(),
            status: $userSubscription->getStatus()->value,
            startDate: $userSubscription->getStartDate()->format('Y-m-d H:m:s'),
            endDate: $userSubscription->getEndDate()->format('Y-m-d H:m:s'),
            subscriptionId: $userSubscription->getSubscription()->getId()->getId()
        );
    }

}