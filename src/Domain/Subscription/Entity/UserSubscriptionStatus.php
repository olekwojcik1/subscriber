<?php

namespace App\Domain\Subscription\Entity;


enum UserSubscriptionStatus: string
{
    case ACTIVE = 'active';
    case IN_ACTIVE = 'in_active';

    case ON_HOLD = 'on_hold';

    case SUSPENDED = 'suspended';

    case RENEWED = 'renewed';

    case EXPIRED = 'expired';


    public static function getAll():array
    {
        return [
          self::EXPIRED,
          self::RENEWED,
          self::SUSPENDED,
          self::ON_HOLD,
          self::IN_ACTIVE,
          self::ACTIVE
        ];
    }

    public function isEqual(self $source): bool
    {
        return $this->value === $source->value;
    }
}