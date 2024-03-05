<?php

namespace App\UI\HTTP\Payment;

use App\Domain\User\Provider\UserProviderInterface;
use App\UI\HTTP\ApiController;
use ErrorException;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Tag;
use Stripe\Stripe;
use Stripe\Subscription;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MakePaymentController extends ApiController
{

    /**
     * @throws \Stripe\Exception\ApiErrorException
     */
    #[Tag(name: 'Payment')]
    #[Get('Make payment')]
    //full doc can be seen in LoginController
    #[Route("", name: "make_payment", methods: ["POST"])]
    public function subscribe(Request $request,
                              ParameterBagInterface $parameterBag, UserProviderInterface $userProvider): Response
    {
        Stripe::setApiKey($parameterBag->get('stripeSK'));

        try {
            // retrieve JSON from request body
            $data = json_decode($request->getContent(), true);

            // Create a subscription -> its just an exmaple
            $subscription = Subscription::create([
                'customer' => $userProvider->getUser()->getId(),
                'items' => [
                    ['price' => $data['price_id']],
                ],
                'expand' => ['latest_invoice.payment_intent']
            ]);

            $output = [
                'subscription_id' => $subscription->id,
                'payment_intent_client_secret' => $subscription->latest_invoice->payment_intent->client_secret,
            ];

            return $this->view($output, self::OK);

        } catch (ErrorException $e) {
            return $this->view($e->getMessage(), 500);
        }
    }
}