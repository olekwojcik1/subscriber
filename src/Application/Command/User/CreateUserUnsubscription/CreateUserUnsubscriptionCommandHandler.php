<?php

namespace App\Application\Command\User\CreateUserUnsubscription;

use App\Domain\Subscription\Entity\UserSubscriptionStatus;
use App\Domain\Subscription\Query\SubscriptionQueryInterface;
use App\Domain\User\Query\UserQueryInterface;
use App\Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateUserUnsubscriptionCommandHandler
{

    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserQueryInterface $userQuery,
        private readonly SubscriptionQueryInterface $subscriptionQuery
    )
    {
    }

    public function __invoke(CreateUserUnsubscriptionCommand $command): void
    {
        $user = $this->userQuery->findOneById($command->getUserId());
        $subscription = $this->subscriptionQuery->findOneById($command->getSubscriptionId());

        $userSubscription = $user->findSubscription(subscription: $subscription);

        $userSubscription->updateEndDate(new \DateTime());
        $userSubscription->updateStatus(UserSubscriptionStatus::IN_ACTIVE->value);

        $this->userRepository->save($user);
    }
}