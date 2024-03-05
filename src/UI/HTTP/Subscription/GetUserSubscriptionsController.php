<?php

namespace App\UI\HTTP\Subscription;

use App\Application\Query\User\VIew\UserViewFactoryInterface;
use App\Domain\User\Provider\UserProviderInterface;
use App\UI\HTTP\ApiController;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Tag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetUserSubscriptionsController extends ApiController
{

    #[Tag(name: 'Subscriptions')]
    #[Get('Get All Subscriptions')]
    //full doc can be seen in LoginController
    #[Route("/me/user", name: "get_user_subscriptions", methods: ["GET"])]
    public function __invoke(UserProviderInterface $userProvider, UserViewFactoryInterface $factory): Response
    {
        $userSubscriptions = $factory->createUserWithUserSubscriptionView($userProvider->getUser());

        return $this->view($userSubscriptions, self::OK);
    }
}