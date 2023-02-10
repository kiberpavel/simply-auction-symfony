<?php

namespace App\Buyers\Infrastructure\Controller;

use App\Buyers\Infrastructure\Service\BuyerCurrent;
use App\Buyers\Infrastructure\Service\BuyerRemove;
use App\Buyers\Infrastructure\Service\BuyerSet;
use App\Buyers\Infrastructure\Service\BuyersList;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BuyerController
{
    public function __construct(
        private readonly BuyerRemove $buyerRemove,
        private readonly BuyersList $buyersList,
        private readonly BuyerCurrent $buyerCurrent,
        private readonly BuyerSet $buyerSet)
    {
    }

    #[Route('api/buyer/set', methods: ['POST'])]
    public function setBuyer(Request $request): JsonResponse
    {
        return $this->buyerSet->createOrUpdate($request);
    }

    #[Route('api/buyer/delete', methods: ['POST'])]
    public function deleteBuyer(Request $request): JsonResponse
    {
        return $this->buyerRemove->remove($request);
    }

    #[Route('api/buyer/list', methods: ['GET'])]
    public function listOfBuyers(): JsonResponse
    {
        return $this->buyersList->output();
    }

    #[Route('api/buyer/current', methods: ['GET'])]
    public function CurrentBuyer(Request $request): JsonResponse
    {
        return $this->buyerCurrent->output($request);
    }
}
