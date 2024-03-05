<?php

namespace App\Application\Command\User\CreateUserSubscription;

use App\Domain\Subscription\Query\SubscriptionQueryInterface;
use App\Domain\User\Query\UserQueryInterface;
use App\Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateUserSubscriptionCommandHandler
{

    public function __construct(
        private readonly UserQueryInterface $userQuery,
        private readonly SubscriptionQueryInterface $subscriptionQuery,
        private readonly UserRepositoryInterface $userRepository
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(CreateUserSubscriptionCommand $command): void
    {
        $user = $this->userQuery->findOneById($command->getUserId());

        $subscription = $this->subscriptionQuery->findOneById($command->getSubscriptionId());

        $user->addSubscription(subscription: $subscription, user: $user);

        $this->userRepository->save($user);
    }
}