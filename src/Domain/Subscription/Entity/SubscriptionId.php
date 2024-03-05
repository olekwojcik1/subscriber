<?php

namespace App\Domain\Subscription\Entity;

use App\Domain\Shared\Entity\Id;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class SubscriptionId extends Id
{

}