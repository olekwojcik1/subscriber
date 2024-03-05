<?php

namespace App\Domain\User\Entity;

use App\Domain\Subscription\Entity\Subscription;
use App\Domain\User\Entity\UserSubscriptions\UserSubscription;
use App\Domain\User\Entity\UserSubscriptions\UserSubscriptionsId;
use Doctrine\Common\Collections\Criteria;

trait SubscriptionUserAPI
{

    /**
     * @throws \Exception
     */
    public function addSubscription(
        Subscription $subscription,
        User $user
    ): void {
        if(!$this->findSubscription($subscription)){
            $this->userSubscriptions->add(
                UserSubscription::create(
                    userSubscriptionId: UserSubscriptionsId::generate(),
                    subscription: $subscription,
                    user: $user
                )
            );
        }
    }

    public function findSubscription(Subscription $subscription): UserSubscription|bool{
        $criteria = Criteria::create()->andWhere(Criteria::expr()->eq('subscription', $subscription));

        return $this->userSubscriptions->matching($criteria)->first();
    }

    //other function like remove or queries with filters
}