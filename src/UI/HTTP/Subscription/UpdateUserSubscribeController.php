<?php

namespace App\UI\HTTP\Subscription;

use App\Application\Command\User\CreateUserSubscription\CreateUserSubscriptionCommand;
use App\Domain\User\Entity\UserSubscriptions\UserSubscriptionsId;
use App\Domain\User\Provider\UserProviderInterface;
use App\UI\HTTP\ApiController;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Tag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateUserSubscribeController extends ApiController
{

    #[Tag(name: 'Subscriptions')]
    #[Get('Subscribe Subscription by user')]
    //full doc can be seen in LoginController
    #[Route("/{subscription_id}/subscribe", name: "subscribe_subscription", methods: ["POST"])]
    public function __invoke(UserProviderInterface $userProvider, string $subscription_id): Response
    {

        $user = $userProvider->getUser();

        $command = new CreateUserSubscriptionCommand(
            userSubscriptionId: UserSubscriptionsId::generate()->getId(),
            userId: $user->getId()->getId(),
            subscriptionId: $subscription_id
        );

        try {
            $this->messageBusHandler->handleCommand($command);
        }catch (\Exception $exception){
            return $this->view($exception->getMessage(), self::CONFLICT);
        }

        return $this->view('OK', self::CREATED);
    }
}