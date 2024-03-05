<?php

namespace App\UI\HTTP\Auth;

use App\Application\Command\User\Create\CreateUserCommand;
use App\Domain\User\Entity\UserId;
use App\Infrastructure\Doctrine\Repository\User\UserRepository;
use App\Infrastructure\Http\ParamFetcher;
use App\UI\HTTP\ApiController;
use Exception;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Tag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Tag(name: 'User Authorization')]
#[Post(summary: 'Register')]
#[\OpenApi\Attributes\Response(response: 201, description: 'user created successfully')]
#[\OpenApi\Attributes\Response(response: 401, description: "JWT Token Expired")]
#[Parameter(name: 'body', in: 'path', required: true, content: new JsonContent(properties: [
        new Property(property: "email", type: "string", default: 'test@test.com'),
        new Property(property: "password", type: "string", default: 'test'),
        new Property(property: "name", type: "string", default: 'Test')
], type: 'object'
))]
class RegisterUserController extends ApiController
{

    #[Route("/register", name: "register_user", methods: ["POST"])]
    public function __invoke(Request $request, UserRepository $userRepository): Response
    {
        $body = ParamFetcher::fromRequestBody($request);

        $userId = UserId::generate();

        try{
            $command = new CreateUserCommand(
                id: $userId,
                email: $body->getRequiredNotEmptyString('email'),
                password: $body->getRequiredString('password'),
                name: $body->getRequiredString('name')
            );


            $this->messageBusHandler->handleCommand($command);

        } catch (Exception $e) {
            return $this->view("Something go wrong", Response::HTTP_BAD_REQUEST);
        }

        return $this->view(['id' => (string)$userId], Response::HTTP_CREATED);
    }
}