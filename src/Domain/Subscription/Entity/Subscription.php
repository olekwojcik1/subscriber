<?php

namespace App\Domain\Subscription\Entity;

use App\Domain\User\Entity\UserSubscriptions\UserSubscription;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "subscriptions")]
class Subscription
{

    #[Embedded(class: SubscriptionId::class, columnPrefix: false)]
    private SubscriptionId $id;

    #[Column(type: 'string', nullable: false)]
    private string $name;

    #[Column(type: 'string', nullable: false)]
    private string $description;

    #[Column(type: "decimal", precision: 10, scale: 2, nullable: false)]
    private float $price;

    #[Column(type: 'integer', nullable: false)]
    private int $duration;

    #[OneToMany(targetEntity: UserSubscription::class, mappedBy: 'subscription', cascade: [
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
        string $name,
        string $description,
        float  $price,
        int    $duration
    ): self {

        $subscription = new self();

        $subscription->id = SubscriptionId::fromString($id);
        $subscription->duration = $duration;
        $subscription->name = $name;
        $subscription->price = round($price, 2);
        $subscription->description = $description;

        return $subscription;
    }

    /**
     * @return \App\Domain\Subscription\Entity\SubscriptionId
     */
    public function getId(): SubscriptionId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserSubscriptions(): Collection
    {
        return $this->userSubscriptions;
    }
}