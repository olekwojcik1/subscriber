<?php

namespace App\UI\HTTP\Subscription;

use App\Application\Query\Subscription\View\SubscriptionViewFactoryInterface;
use App\Domain\Subscription\Entity\Subscription;
use App\Domain\Subscription\Query\SubscriptionQueryInterface;
use App\UI\HTTP\ApiController;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Tag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetAllSubscriptionsController
extends ApiController
{

    #[Tag(name: 'Subscriptions')]
    #[Get('Get All Subscriptions')]
    //full doc can be seen in LoginController
    #[Route("", name: "get_subscriptions", methods: ["GET"])]
    public function __invoke(SubscriptionQueryInterface $subscriptionQuery, SubscriptionViewFactoryInterface $factory): Response
    {

        $subscriptions = array_map(fn(Subscription $subscription) => $factory->createBasicView($subscription), $subscriptionQuery->findAll());

        return $this->view($subscriptions, self::OK);
    }
}