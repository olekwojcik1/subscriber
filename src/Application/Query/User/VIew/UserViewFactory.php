<?php

namespace App\Application\Query\User\VIew;

use App\Application\Query\User\VIew\UserSubscriptionView\UserSubscriptionViewFactoryInterface;
use App\Domain\User\Entity\User;
use App\Domain\User\Entity\UserSubscriptions\UserSubscription;

readonly class UserViewFactory implements UserViewFactoryInterface
{


    public function __construct(
        private UserSubscriptionViewFactoryInterface $factory
    ) {
    }

    public function createBasicView(User $user): UserViewInterface
    {
        return new UserView(
            id: $user->getId(), email: $user->getEmail(), name: $user->getName()
        );
    }

    public function createUserWithUserSubscriptionView(User $user): UserViewInterface
    {
        $userSubscriptions = $user->getUserSubscriptions() ? array_map(fn(
            UserSubscription $userSubscription
        ) => $this->factory->createUserSubscriptionView($userSubscription),
            $user->getUserSubscriptions()->getValues()) : null;


        return new UserWithSubscriptionsView(
          id: $user->getId()->getId(),
            name: $user->getName(),
            email: $user->getEmail(),
            subscriptions: $userSubscriptions
        );

    }

}