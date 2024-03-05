<?php

namespace App\Domain\User\Query;

use App\Domain\User\Entity\User;

interface UserQueryInterface
{
    public function findOneById(string $id): User;

    public function findOneByEmail(string $email): ?User;

    public function findAll(): array;
}