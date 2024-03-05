<?php

namespace App\UI\HTTP\Auth;

use App\Application\Command\Auth\CreateToken\CreateTokenCommand;
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
#[Post(summary: 'Login')]
#[\OpenApi\Attributes\Response(response: 200, description: 'Return JWT Token for User',
    content: new JsonContent(properties: [new Property(property: 'token', type: 'string')]))]
#[\OpenApi\Attributes\Response(response: 401, description: "JWT Token Expired")]
#[Parameter(name: 'body', in: 'path', required: true,
    content: new JsonContent(properties: [
        new Property(property: "email", type: "string", default: 'test@test.com'),
        new Property(property: "password", type: "string", default: 'test'),
], type: 'object'
))]
class LoginController extends ApiController
{
    #[Route("/login", name: "api_auth_login", methods: ["POST"])]
    public function __invoke(Request $request, UserRepository $userRepository): Response
    {

        $paramFetcher = ParamFetcher::fromRequestBody($request);

        $command = new CreateTokenCommand(
            email: $paramFetcher->getRequiredNotEmptyString('email'),
            password: $paramFetcher->getRequiredNotEmptyString('password')
        );

        try {
            $hash = $this->messageBusHandler->handleCommand($command);
        } catch (Exception $e) {
            return $this->view('Invalid credentials: ' . $e->getMessage(), Response::HTTP_UNAUTHORIZED);
        }

        return $this->view(['token' => $hash], Response::HTTP_OK);
    }
}