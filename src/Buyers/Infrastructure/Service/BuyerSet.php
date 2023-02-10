<?php

namespace App\Buyers\Infrastructure\Service;

use App\Buyers\Domain\Repository\BuyerRepositoryInterface;
use App\Buyers\Infrastructure\Adapters\LotAdapter;
use App\Buyers\Infrastructure\Adapters\UserAdapter;
use App\Shared\Infrastructure\Helper\ResponseMessage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BuyerSet
{
    public function __construct(
        private readonly BuyerRepositoryInterface $buyerRepository,
        private readonly BuyerCreation $buyerCreation,
        private readonly BuyerUpdate $buyerUpdate,
        private readonly LotAdapter $lotAdapter,
        private readonly UserAdapter $userAdapter)
    {
    }

    public function createOrUpdate(Request $request = null, string $lotId = null, string $userId = null): JsonResponse
    {
        if (is_null($lotId)) {
            $lotId = $request->get('lotId');
        }
        if (is_null($userId)) {
            $userId = $request->get('userId');
        }

        if (!$lotId || !$userId) {
            return new JsonResponse([
                'error' => ResponseMessage::PARAMS_ERROR,
            ], 400);
        }

        $lot = $this->lotAdapter->importLot($lotId);
        $user = $this->userAdapter->importUser($userId);

        $buyer = $this->buyerRepository->getRecordByLot($lot);

        if (!empty($buyer)) {
            return $this->buyerUpdate->update($buyer, $userId);
        }

        return $this->buyerCreation->create($lot, $user);
    }
}
