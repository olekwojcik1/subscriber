<?php

namespace App\Infrastructure\User;

use App\Domain\User\Entity\User;
use App\Domain\User\Provider\UserProviderInterface;
use Symfony\Bundle\SecurityBundle\Security;

readonly class UserProvider implements UserProviderInterface
{


    public function __construct(
        private Security $security,
    ) {
    }


    public function getUser(): ?User
    {
        /** @var User $user */
        $user =  $this->security->getUser();

        return $user ?? null;
    }

}