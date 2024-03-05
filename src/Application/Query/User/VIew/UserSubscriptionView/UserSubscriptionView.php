<?php

namespace App\Application\Query\User\VIew\UserSubscriptionView;

class UserSubscriptionView implements UserSubscriptionViewInterface
{

    public function __construct(
        private string $id,
        private string $status,
        private string $startDate,
        private string $endDate,
        private string $subscriptionId
    )
    {
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getStartDate(): string
    {
        return $this->startDate;
    }

    /**
     * @return string
     */
    public function getEndDate(): string
    {
        return $this->endDate;
    }

    /**
     * @return string
     */
    public function getSubscriptionId(): string
    {
        return $this->subscriptionId;
    }

}