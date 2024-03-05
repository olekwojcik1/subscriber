<?php

namespace App\Domain\User\Entity;

use App\Domain\User\Entity\UserSubscriptions\UserSubscription;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[Entity]
#[Table(name: "users")]
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    use SubscriptionUserAPI;

    const ROLE_USER = 'ROLE_USER';

    #[Embedded(class: UserId::class, columnPrefix: false)]
    private UserId $id;

    #[Column(type: 'string', unique: true)]
    private string $email;

    #[Column(type: "string", nullable: false)]
    private string $password;

    #[Column(type: "string", nullable: false)]
    private string $name;

    #[Column(type: "array", nullable: false)]
    private array $roles = [];


    #[OneToMany(targetEntity: UserSubscription::class, mappedBy: 'user', cascade: [
        'remove',
        'persist',
    ], orphanRemoval: true)]
    private Collection $userSubscriptions;

    public function __construct()
    {
        $this->userSubscriptions = new ArrayCollection();
    }

    public static function create(
        string $id,
        string $email,
        string $name,

    ): self{
        $user = new self();
        $user->id = UserId::fromString($id);
        $user->email = $email;
        $user->name = $name;
        $user->roles = [self::ROLE_USER];

        return $user;
    }

    public function updatePassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }


    public function getRoles(): array
    {
        return $this->roles;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @return \App\Domain\User\Entity\UserId
     */
    public function getId(): UserId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserSubscriptions(): Collection
    {
        return $this->userSubscriptions;
    }


}
