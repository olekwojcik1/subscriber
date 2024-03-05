<?php

namespace App\Application\Query\Subscription\View;

class SubscriptionView implements SubscriptionViewInterface
{

    public function __construct(
        private string $id,
        private string $name,
        private string $descirption,
        private float $price,
        private int $duration,
    )
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescirption(): string
    {
        return $this->descirption;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
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
    public function getId(): string
    {
        return $this->id;
    }



}