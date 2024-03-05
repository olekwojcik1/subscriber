<?php

namespace App\Infrastructure\DataFixtures;

use App\Application\Command\Subscription\Create\CreateSubscriptionCommand;
use App\Application\MessageBusHandler\MessageBusHandler;
use App\Domain\Subscription\Entity\SubscriptionId;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubscriptionFixtures extends Fixture
{

    public const SUBSCRIPTIONS = [
        [
            'id' => 'subscription_1',
            'name' => 'subscription_1',
            'description' => 'subscription_1',
            'price' => 1.00,
            'duration' => 31556926
        ],
        [
            'id' => 'subscription_2',
            'name' => 'subscription_2',
            'description' => 'subscription_2',
            'price' => 2.00,
            'duration' => 31556926
        ],
        [
            'id' => 'subscription_3',
            'name' => 'subscription_3',
            'description' => 'subscription_3',
            'price' => 3.00,
            'duration' => 31556926
        ],
    ];

    public function __construct(
        private readonly MessageBusHandler $messageBusHandler
    )
    {
    }


    public function load(ObjectManager $manager): void
    {
        foreach (self::SUBSCRIPTIONS as $subscription) {
            $this->messageBusHandler->handleCommand(
                new CreateSubscriptionCommand(
                     subscriptionId: SubscriptionId::fromString($subscription['id']),
                    name: $subscription['name'],
                    duration: $subscription['duration'],
                    description: $subscription['description'],
                    price: $subscription['price']
                )
            );
        }
    }

}