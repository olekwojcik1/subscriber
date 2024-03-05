<?php

namespace App\Application\Command\User\CreateUserSubscription;

class CreateUserSubscriptionCommand
{

    public function __construct(
        private string $userSubscriptionId,
        private string $userId,
        private string $subscriptionId,
    )
    {
    }

    /**
     * @return string
     */
    public function getUserSubscriptionId(): string
    {
        return $this->userSubscriptionId;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getSubscriptionId(): string
    {
        return $this->subscriptionId;
    }
}