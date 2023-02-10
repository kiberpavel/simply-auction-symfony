<?php

namespace App\Orders\Infrastructure\Service;

use App\Orders\Domain\Factory\OrderFactory;
use App\Orders\Domain\Repository\OrderRepositoryInterface;
use App\Orders\Infrastructure\Adapters\BuyerAdapter;
use App\Orders\Infrastructure\Adapters\LotAdapter;
use App\Shared\Infrastructure\Helper\ResponseMessage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OrderSet
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly OrderFactory $orderFactory,
        private readonly BuyerAdapter $buyerAdapter,
        private readonly LotAdapter $lotAdapter)
    {
    }

    public function addOrder(Request $request): JsonResponse
    {
        $lotId = $request->get('lotId');

        if (!$lotId) {
            return new JsonResponse([
                'error' => ResponseMessage::PARAMS_ERROR,
            ], 400);
        }

        $lot = $this->lotAdapter->importLot($lotId);

        $apiBuyer = $this->buyerAdapter->importBuyerByLot($lot);

        $buyerId = $apiBuyer[0]->getId();

        $buyer = $this->buyerAdapter->importBuyer($buyerId);

        $record = $this->orderRepository->findByBuyer($buyer);

        if (!empty($record)) {
            return new JsonResponse(['message' => ResponseMessage::ADD_RECORD]);
        }

        try {
            $order = $this->orderFactory->create($buyer);
            $this->orderRepository->add($order);
            $this->lotAdapter->updateStatus($lotId);
        } catch (\TypeError $error) {
            return new JsonResponse([
                'error' => $error->getMessage(),
            ], 500);
        }

        return new JsonResponse(['message' => ResponseMessage::ADD_RECORD]);
    }
}
