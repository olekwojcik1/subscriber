<?php

namespace App\UI\HTTP;

use App\Application\MessageBusHandler\MessageBusHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

abstract class ApiController extends AbstractController
{

    public const        OK          = 200;

    public const        CREATED     = 201;

    public const        NO_CONTENT  = 204;

    public const        CONFLICT    = 409;

    public const        NOT_FOUND   = 404;

    public const        VOTE_READ   = 'read';

    public const        VOTE_WRITE  = 'write';

    public const        BAD_REQUEST = 400;

    /**
     * @var SerializerInterface
     */
    private $serializer;


    protected MessageBusHandler $messageBusHandler;

    public function __construct(
        SerializerInterface $serializer,
        MessageBusHandler   $messageBusHandler
    ) {
        $this->serializer = $serializer;
        $this->messageBusHandler = $messageBusHandler;
    }

    protected function getContent(Request $request)
    {
        $content = $request->getContent();

        return $this->jsonToArray($content);
    }

    protected function jsonToArray($arg)
    {
        $data = json_decode($arg, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new BadRequestHttpException('invalid json body: ' . json_last_error_msg());
        }

        return $data;
    }

    protected function view(
        $arg,
        $code = 200,
        $group = null,
        $context = []
    ): Response{
        if ($group) {
            $context['groups'] = [$group];
        }

        return new Response(
            $arg ? $this->serializer->serialize($arg, 'json', $context) : null,
            $code,
            [
                'Content-Type'                => 'application/json',
                'Access-Control-Allow-Origin' => '*',
            ],

        );
    }


}