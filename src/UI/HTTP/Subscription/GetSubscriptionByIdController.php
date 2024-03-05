<?php

namespace App\UI\HTTP\Subscription;

use App\Application\Query\Subscription\View\SubscriptionViewFactoryInterface;
use App\Domain\Subscription\Query\SubscriptionQueryInterface;
use App\UI\HTTP\ApiController;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Tag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetSubscriptionByIdController extends ApiController
{

    #[Tag(name: 'Subscriptions')]
    #[Get('Get All Subscriptions')]
    //full doc can be seen in LoginController
    #[Route("/{id}", name: "get_subscription", methods: ["GET"])]
    public function __invoke(string $id, SubscriptionQueryInterface $subscriptionQuery, SubscriptionViewFactoryInterface $factory): Response
    {
        $subscriptionView = $factory->createBasicView($subscriptionQuery->findOneById($id));

        return $this->view($subscriptionView, self::OK);
    }


}