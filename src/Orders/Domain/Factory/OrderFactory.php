<?php

namespace App\Orders\Domain\Factory;

use App\Buyers\Domain\Entity\Buyer;
use App\Orders\Domain\Entity\Order;

class OrderFactory
{
    public function create(Buyer $buyer): Order
    {
        return new Order($buyer);
    }
}
