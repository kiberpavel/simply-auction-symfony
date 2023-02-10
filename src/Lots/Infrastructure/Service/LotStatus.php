<?php

namespace App\Lots\Infrastructure\Service;

use App\Lots\Domain\Entity\Lot;
use App\Lots\Domain\Repository\LotRepositoryInterface;

class LotStatus
{
    public function __construct(private readonly LotRepositoryInterface $lotRepository)
    {
    }

    public function change(string $id): void
    {
        $lot = $this->lotRepository->findById($id);

        $lot->setStatus(Lot::STATUS_IS_INACTIVE);
        $this->lotRepository->update();
    }
}
