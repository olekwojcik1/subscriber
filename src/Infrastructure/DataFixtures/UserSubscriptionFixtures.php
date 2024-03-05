<?php

namespace App\Infrastructure\DataFixtures;

use App\Application\Command\User\CreateUserSubscription\CreateUserSubscriptionCommand;
use App\Application\MessageBusHandler\MessageBusHandler;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserSubscriptionFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(
        private readonly MessageBusHandler $messageBusHandler
    )
    {
    }


    public function load(ObjectManager $manager): void
    {

        $this->messageBusHandler->handleCommand(new CreateUserSubscriptionCommand(
            userSubscriptionId: 'user_subscription_1',
            userId: 'user_1',
            subscriptionId: 'subscription_1'
        ));

    }

    public function getDependencies(): array
    {
        return [
            SubscriptionFixtures::class,
            UserFixtures::class,
        ];
    }

}