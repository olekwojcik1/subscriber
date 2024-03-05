<?php

namespace App\Application\Command\Auth\CreateToken;

use App\Domain\User\Query\UserQueryInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsMessageHandler]
class CreateTokenHandler
{

    public function __construct(
        private JWTTokenManagerInterface    $JWTTokenManager,
        private UserPasswordHasherInterface $passwordHasher,
        private LoggerInterface             $logger,
        private readonly UserQueryInterface $userQuery

    ) {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(CreateTokenCommand $tokenCommand): string
    {

        $user = $this->userQuery->findOneByEmail($tokenCommand->getEmail());

        if (!$user) {
            $this->logger->info("User {$tokenCommand->getEmail()} not exists");
            throw new \Exception("Invalid credentials");
        }

        if (!$this->passwordHasher->isPasswordValid($user, $tokenCommand->getPassword())) {
            $this->logger->info("Password incorrect");
            throw new \Exception("Invalid credentials password");
        }

        return $this->JWTTokenManager->create($user);
    }

}