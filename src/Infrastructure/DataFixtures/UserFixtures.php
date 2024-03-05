<?php

namespace App\Infrastructure\DataFixtures;

use App\Application\Command\User\Create\CreateUserCommand;
use App\Application\MessageBusHandler\MessageBusHandler;
use App\Domain\User\Entity\User;
use App\Domain\User\Entity\UserId;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures
    extends Fixture
{
    public const USERS = [
        [
            'id'       => 'user_1',
            'email'    => 'user1@test.com',
            'password' => 'user_1',
            'name'     => 'user_1',
            'role'     => User::ROLE_USER,
        ],
        [
            'id'       => 'user_2',
            'name'     => 'user_2',
            'email'    => 'user2@test.com',
            'password' => 'user_2',
            'role'     => User::ROLE_USER,
        ],
    ];

    public function __construct(
        private readonly MessageBusHandler $messageBusHandler,
    )
    {
    }


    public function load(ObjectManager $manager): void
    {
        foreach (self::USERS as $user) {
            $this->messageBusHandler->handleCommand(
                new CreateUserCommand(
                    id: UserId::fromString($user['id']),
                    email: $user['email'],
                    password: $user['password'],
                    name: $user['name'],
                )
            );
        }
    }
}