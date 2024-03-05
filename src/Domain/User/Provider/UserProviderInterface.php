<?php

namespace App\Domain\User\Provider;

use App\Domain\User\Entity\User;


interface UserProviderInterface
{
    public function getUser(): ?User;
}