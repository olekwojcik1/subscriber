<?php

namespace App\Domain\Shared\Entity;

use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Ramsey\Uuid\Uuid;

#[ORM\Embeddable]
class Id
{

    #[ORM\Id]
    #[ORM\Column(type: 'string', unique: true)]
    protected string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public static function generate(): static
    {
        return new static(Uuid::uuid4());
    }

    #[Pure] public static function fromString(string $id): static
    {
        return new static($id);
    }

    #[Pure] public function isEqual(Id $id): bool
    {
        return $this->id === $id->getId();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }


}
