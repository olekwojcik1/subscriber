<?php

namespace App\Application\Query\User\VIew;

class UserView implements UserViewInterface
{

    public function __construct(
        private string $id,
        private string $email,
        private string $name,

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
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}