<?php

namespace App\Infrastructure\Doctrine\Repository\ORM;

use Doctrine\ORM\EntityManagerInterface;

abstract class BaseRepository
{
    public function __construct(protected EntityManagerInterface $_em)
    {
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    protected function findById(string $class, string $id)
    {
        return $this->_em->find($class, $id) ?: throw new \Exception(
            $class.' not exist, Id: '.$id
        );
    }

    protected function saveObj($obj): void
    {
        $this->_em->persist($obj);
        $this->_em->flush();
    }

    protected function removeObj($obj): void
    {
        $this->_em->remove($obj);
        $this->_em->flush();
    }

}