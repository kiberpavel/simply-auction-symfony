<?php

namespace App\Buyers\Infrastructure\API;

use App\Buyers\Domain\Entity\Buyer;
use App\Buyers\Domain\Repository\BuyerRepositoryInterface;
use App\Buyers\Infrastructure\Service\BuyerSet;
use App\Lots\Domain\Entity\Lot;
use Symfony\Component\HttpFoundation\JsonResponse;

class BuyerApi
{
    public function __construct(
        private readonly BuyerSet $buyerSet,
        private readonly BuyerRepositoryInterface $buyerRepository)
    {
    }

    public function setBuyer(string $lotId, string $userId): JsonResponse
    {
        return $this->buyerSet->createOrUpdate(null, $lotId, $userId);
    }

    public function exportBuyer(string $id): Buyer
    {
        return $this->buyerRepository->findById($id);
    }

    public function exportBuyerByLot(Lot $lot): array
    {
        return $this->buyerRepository->getRecordByLot($lot);
    }
}
