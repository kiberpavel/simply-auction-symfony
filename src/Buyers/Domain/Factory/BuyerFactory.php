<?php

namespace App\Buyers\Domain\Factory;

use App\Buyers\Domain\Entity\Buyer;
use App\Lots\Domain\Entity\Lot;
use App\Users\Domain\Entity\User;

class BuyerFactory
{
    public function create(Lot $lot, User $user): Buyer
    {
        return new Buyer($lot, $user);
    }
}
