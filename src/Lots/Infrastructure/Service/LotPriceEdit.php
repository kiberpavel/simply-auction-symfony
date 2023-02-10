<?php

namespace App\Lots\Infrastructure\Service;

use App\Lots\Domain\Repository\LotRepositoryInterface;
use App\Lots\Infrastructure\Adapters\BuyerAdapter;
use App\Shared\Domain\Security\UserFetcherInterface;
use App\Shared\Infrastructure\Helper\ResponseMessage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class LotPriceEdit
{
    public function __construct(
        private readonly LotRepositoryInterface $lotRepository,
        private readonly BuyerAdapter $buyerAdapter,
        private readonly UserFetcherInterface $userFetcher)
    {
    }

    public function edit(Request $request): JsonResponse
    {
        $id = $request->get('id');
        $requestPrice = $request->get('price');
        $user = $this->userFetcher->getAuthUser();

        if (!$id || !$requestPrice) {
            return new JsonResponse([
                'error' => ResponseMessage::PARAMS_ERROR,
            ], 400);
        }

        $lot = $this->lotRepository->findById($id);

        if ($requestPrice <= $lot->getPrice()) {
            return new JsonResponse([
                'error' => ResponseMessage::INVALID_DATA,
            ], 400);
        }

        $lot->setPrice($requestPrice);
        $this->lotRepository->update();

        return $this->buyerAdapter->setBuyer($id, $user->getId());
    }
}
