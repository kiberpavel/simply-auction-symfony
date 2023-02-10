<?php

namespace App\Orders\Infrastructure\Adapters;

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

    public function updateStatus(string $id): void
    {
        $this->lotApi->updateStatus($id);
    }
}
