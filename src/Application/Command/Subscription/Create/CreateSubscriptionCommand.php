<?php

namespace App\Application\Command\Subscription\Create;

class CreateSubscriptionCommand
{

    public function __construct(
        private string $subscriptionId,
        private string $name,
        private int    $duration,
        private string $description,
        private string $price
    ) {
    }

    /**
     * @return string
     */
    public function getSubscriptionId(): string
    {
        return $this->subscriptionId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

}