<?php

namespace App\Buyers\Infrastructure\Adapters;

use App\Lots\Domain\Entity\Lot;
use App\Lots\Infrastructure\API\LotApi;

class LotAdapter
{
    public function __construct(private readonly LotApi $lotApi)
    {
    }

    public function importLot(string $id): Lot
    {
        return $this->lotApi->exportLot($id);
    }
}
