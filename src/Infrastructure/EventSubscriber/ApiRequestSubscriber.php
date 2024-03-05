<?php

namespace App\Infrastructure\EventSubscriber;

use JsonException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiRequestSubscriber implements EventSubscriberInterface
{

    private const DEFAULT_JSON_DEPTH = 512;

    /**
     * @return array<string, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::REQUEST => 'onRequest'];
    }

    public function onRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        if (\is_resource($request->getContent())
            || $request->getContent() === ''
            || str_starts_with($request->getPathInfo(), '/api/doc')
            || str_starts_with($request->getPathInfo(), '/api/main/message-consume')
            || !str_starts_with($request->getPathInfo(), '/api/')) {
            return;
        }

        try {
            if ($request->request?->all()) {
                $requestContent = $request->request?->all();
            } else {
                $requestContent = json_decode(
                    $request->getContent(),
                    true,
                    self::DEFAULT_JSON_DEPTH,
                    JSON_THROW_ON_ERROR
                );
            }
        } catch (JsonException $e) {
            $event->setResponse(new JsonResponse('Invalid json string', Response::HTTP_BAD_REQUEST));

            return;
        }

        if (\is_array($requestContent)) {
            $request->request->replace($requestContent);
        }
    }

}