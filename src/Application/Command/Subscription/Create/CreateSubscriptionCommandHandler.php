<?php

namespace App\Application\Command\Subscription\Create;

use App\Domain\Subscription\Entity\Subscription;
use App\Domain\Subscription\Repository\SubscriptionRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateSubscriptionCommandHandler
{

    public function __construct(
        private readonly SubscriptionRepositoryInterface $repository
    )
    {
    }

    public function __invoke(CreateSubscriptionCommand $command): void
    {
        $subscription = Subscription::create(
            id: $command->getSubscriptionId(),
            name: $command->getName(),
            description: $command->getDescription(),
            price: $command->getPrice(),
            duration: $command->getDuration()
        );

        $this->repository->save($subscription);
    }
}