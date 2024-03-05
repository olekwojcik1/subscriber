<?php

namespace App\Application\Query\User\VIew;

class UserWithSubscriptionsView implements UserViewInterface
{

    public function __construct(
        private string $id,
        private string $name,
        private string $email,
        private array $subscriptions
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function getSubscriptions(): array
    {
        return $this->subscriptions;
    }

}