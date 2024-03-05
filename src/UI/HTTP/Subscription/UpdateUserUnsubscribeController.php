<?php

namespace App\UI\HTTP\Subscription;

use App\Application\Command\User\CreateUserUnsubscription\CreateUserUnsubscriptionCommand;
use App\Domain\Subscription\Entity\UserSubscriptionStatus;
use App\Domain\User\Provider\UserProviderInterface;
use App\UI\HTTP\ApiController;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Tag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateUserUnsubscribeController extends ApiController
{
    #[Tag(name: 'Subscriptions')]
    #[Get('Unsubscribe Subscription by user')]
    //full doc can be seen in LoginController
    #[Route("/{subscription_id}/unsubscribe", name: "unsubscribe_subscription", methods: ["PUT"])]
    public function __invoke(UserProviderInterface $userProvider, string $subscription_id): Response
    {

        $user = $userProvider->getUser();

        $command = new CreateUserUnsubscriptionCommand(
            userId: $user->getId()->getId(),
            subscriptionId: $subscription_id,
            status: UserSubscriptionStatus::IN_ACTIVE->value
        );

        try {
            $this->messageBusHandler->handleCommand($command);
        }catch (\Exception $exception){
            return $this->view($exception->getMessage(), self::CONFLICT);
        }

        return $this->view('OK', self::CREATED);
    }
}