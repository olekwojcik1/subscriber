<?php

namespace App\UI\CLI;

use App\Application\Command\User\CreateUserUnsubscription\CreateUserUnsubscriptionCommand;
use App\Application\MessageBusHandler\MessageBusHandler;
use App\Domain\Subscription\Entity\UserSubscriptionStatus;
use App\Infrastructure\Doctrine\Repository\User\UserSubscriptionRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateUserSubscriptionCommand extends Command
{

    //such command should be included in CRON, as user should not be charged if end date
    // is lower than current time. This command will look for such subscriptions
    // and change status
    public const NAME = 'update:user:subscription:by:date';

    public function __construct(
        private UserSubscriptionRepository $repository,
        private MessageBusHandler $messageBusHandler
    ) {
        parent::__construct(self::NAME);
    }

    protected function execute(InputInterface  $input,
                               OutputInterface $output
    ): int {

        $subscriptionToDeactive = $this->repository->findAllSubscriptionWhereEnDateIsLowerThenCurrentDate();

        /** @var \App\Domain\User\Entity\UserSubscriptions\UserSubscription $item */
        foreach ($subscriptionToDeactive as $item) {
            $this->messageBusHandler->handleCommand(
                new CreateUserUnsubscriptionCommand(
                    userId: $item->getUser()->getId()->getId(),
                    subscriptionId: $item->getSubscription()->getId()->getId(),
                    status: UserSubscriptionStatus::IN_ACTIVE->value
                )
            );

        }



        return Command::SUCCESS;
    }

}