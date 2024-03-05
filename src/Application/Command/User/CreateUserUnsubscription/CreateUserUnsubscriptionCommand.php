<?php

namespace App\Application\Command\User\CreateUserUnsubscription;

use App\Domain\Subscription\Entity\UserSubscriptionStatus;

class CreateUserUnsubscriptionCommand
{

    public function __construct(
        private readonly string $userId,
        private readonly string $subscriptionId,
        private readonly ?string $status = UserSubscriptionStatus::IN_ACTIVE->value
    )
    {
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

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

}