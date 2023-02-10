<?php

namespace App\Lots\Domain\Factory;

use App\Lots\Domain\Entity\Lot;
use App\Users\Domain\Entity\User;

class LotFactory
{
    public function create(
        User $user,
        string $shortName,
        float $price,
        string $description,
        string $image_url,
        string $end_trade_time,
        string $status = Lot::STATUS_IS_ACTIVE,
    ): Lot {
        return new Lot($user, $status, $shortName, $price, $description, $image_url, $end_trade_time);
    }
}
