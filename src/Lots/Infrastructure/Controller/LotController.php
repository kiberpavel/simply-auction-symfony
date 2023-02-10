<?php

namespace App\Lots\Infrastructure\Controller;

use App\Lots\Infrastructure\Service\LotCreation;
use App\Lots\Infrastructure\Service\LotEdit;
use App\Lots\Infrastructure\Service\LotPriceEdit;
use App\Lots\Infrastructure\Service\LotRemove;
use App\Lots\Infrastructure\Service\LotsList;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LotController
{
    public function __construct(
        private readonly LotCreation $lotCreation,
        private readonly LotRemove $lotRemove,
        private readonly LotEdit $lotEdit,
        private readonly LotsList $lotsList,
        private readonly LotPriceEdit $lotPriceEdit)
    {
    }

    #[Route('api/lot/create', methods: ['POST'])]
    public function addNewLot(Request $request): JsonResponse
    {
        return $this->lotCreation->createLot($request);
    }

    #[Route('api/lot/delete', methods: ['POST'])]
    public function removeLot(Request $request): JsonResponse
    {
        return $this->lotRemove->removeLot($request);
    }

    #[Route('api/lot/update', methods: ['POST'])]
    public function updateLot(Request $request): JsonResponse
    {
        return $this->lotEdit->editLot($request);
    }

    #[Route('api/lot/list', methods: ['GET'])]
    public function listOfLots(): JsonResponse
    {
        return $this->lotsList->outputLots();
    }

    #[Route('api/lot/edit/price', methods: ['POST'])]
    public function updatePrice(Request $request): JsonResponse
    {
        return $this->lotPriceEdit->edit($request);
    }
}
