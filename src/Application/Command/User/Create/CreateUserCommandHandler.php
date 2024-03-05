<?php

namespace App\Application\Command\User\Create;

use App\Domain\User\Entity\User;
use App\Domain\User\Query\UserQueryInterface;
use App\Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsMessageHandler]
class CreateUserCommandHandler
{

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly UserQueryInterface          $userQuery,
        private readonly UserRepositoryInterface     $userRepository
    ) {
    }

    public function __invoke(CreateUserCommand $command): void
    {

        $user = $this->userQuery->findOneByEmail($command->getEmail());

        if ($user) {
            throw new \Exception("User already exists");
        }

        $user = User::create(
            id: $command->getId(),email: $command->getEmail(),name: $command->getName()
        );

        $user->updatePassword($this->passwordHasher->hashPassword(user: $user, plainPassword: $command->getPassword()));

        $this->userRepository->save($user);

    }
}