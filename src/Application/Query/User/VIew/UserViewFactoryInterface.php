<?php

namespace App\Application\Query\User\VIew;

use App\Domain\User\Entity\User;

interface UserViewFactoryInterface
{

    public function createBasicView(User $user): UserViewInterface;

    public function createUserWithUserSubscriptionView(User $user): UserViewInterface;

}