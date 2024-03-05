<?php

namespace App\Application\Command\User\Create;

class CreateUserCommand
{
    /**
     * @param string $id
     * @param string $email
     * @param string $password
     * @param string $name
     */
    public function __construct(
        private string $id,
        private string $email,
        private string $password,
        private string $name
    ) {
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
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


}