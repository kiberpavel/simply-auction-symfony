<?php

namespace App\Lots\Infrastructure\API;

use App\Lots\Domain\Entity\Lot;
use App\Lots\Domain\Repository\LotRepositoryInterface;
use App\Lots\Infrastructure\Service\LotStatus;

class LotApi
{
    public function __construct(
        private readonly LotRepositoryInterface $lotRepository,
        private readonly LotStatus $lotStatus)
    {
    }

    public function exportLot(string $id): Lot
    {
        return $this->lotRepository->findById($id);
    }

    public function updateStatus(string $id): void
    {
        $this->lotStatus->change($id);
    }
}
