<?php

namespace App\Domain\User\Entity;

use App\Domain\Shared\Entity\Id;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class UserId extends Id
{

}
