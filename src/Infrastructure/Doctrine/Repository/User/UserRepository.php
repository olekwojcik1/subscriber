<?php

namespace App\Infrastructure\Doctrine\Repository\User;

use App\Domain\User\Entity\User;
use App\Domain\User\Query\UserQueryInterface;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\Doctrine\Repository\ORM\BaseRepository;
use Doctrine\ORM\NonUniqueResultException;

class UserRepository extends BaseRepository implements UserQueryInterface, UserRepositoryInterface
{

    public function save(User $user): void
    {
        $this->saveObj($user);
    }

    /**
     * @param string $email
     * @return User|null
     * @throws NonUniqueResultException
     */
    public function findOneByEmail(string $email): ?User
    {

        $qb = $this->_em->createQueryBuilder();
        $q = $qb
            ->select('u')
            ->from(User::class, 'u')
            ->andWhere($qb->expr()->lower('u.email') . ' = :email')
            ->setParameter('email', strtolower(trim($email)));

        return $q->getQuery()->getOneOrNullResult();
    }

    public function findAll(): array
    {
        $qb = $this->_em->createQueryBuilder();
        $q = $qb
            ->select('u')
            ->from(User::class, 'u');

        return $q->getQuery()->getResult();
    }

    /**
     * @throws \Exception
     */
    public function findOneById(string $id): User
    {
        return $this->findById(User::class, $id);
    }
}