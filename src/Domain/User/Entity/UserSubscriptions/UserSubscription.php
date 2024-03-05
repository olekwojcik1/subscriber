<?php

namespace App\Domain\User\Entity\UserSubscriptions;

use App\Domain\Subscription\Entity\Subscription;
use App\Domain\Subscription\Entity\UserSubscriptionStatus;
use App\Domain\User\Entity\User;
use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "user_subscriptions")]
class UserSubscription
{

    #[Embedded(class: UserSubscriptionsId::class, columnPrefix: false)]
    private UserSubscriptionsId $id;

    #[Column(type: "string", nullable: false)]
    private string $status;

    #[Column(type: "datetime", nullable: false)]
    private DateTime $startDate;

    #[Column(type: "datetime", nullable: false)]
    private DateTime $endDate;

    #[ManyToOne(targetEntity: Subscription::class, inversedBy: "userSubscriptions")]
    private Subscription $subscription;

    #[ManyToOne(targetEntity: User::class, inversedBy: "userSubscriptions")]
    private User $user;

    /**
     * @throws \Exception
     */
    public function __construct(Subscription $subscription)
    {
        $this->startDate = new DateTime();
        $this->endDate = $this->startDate->add(new \DateInterval('PT' . $subscription->getDuration() . 'S'));
    }

    /**
     * @throws \Exception
     */
    public static function create(
        string       $userSubscriptionId,
        Subscription $subscription,
        User         $user
    ): self {
        $us = new self($subscription);
        $us->id = UserSubscriptionsId::fromString($userSubscriptionId);
        $us->user = $user;
        $us->status = UserSubscriptionStatus::ACTIVE->value;
        $us->subscription = $subscription;

        return $us;
    }

    /**
     * @return \App\Domain\User\Entity\UserSubscriptions\UserSubscriptionsId
     */
    public function getId(): UserSubscriptionsId
    {
        return $this->id;
    }

    /**
     * @return UserSubscriptionStatus
     */
    public function getStatus(): UserSubscriptionStatus
    {
        return UserSubscriptionStatus::from($this->status);
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    /**
     * @return \App\Domain\Subscription\Entity\Subscription
     */
    public function getSubscription(): Subscription
    {
        return $this->subscription;
    }

    /**
     * @return \App\Domain\User\Entity\User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    public function updateStatus(string $status): void
    {
        $this->status = $status;
    }

    public function updateEndDate(DateTime $dateTime): void
    {
        $this->endDate = $dateTime;
    }


}