<?php

namespace App\Application\Query\User\VIew\UserSubscriptionView;

use App\Domain\User\Entity\UserSubscriptions\UserSubscription;

interface UserSubscriptionViewFactoryInterface
{
    public function createUserSubscriptionView(UserSubscription $userSubscription): UserSubscriptionViewInterface;
}