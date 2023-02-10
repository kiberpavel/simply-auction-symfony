<?php

namespace App\Buyers\Infrastructure\Service;

use App\Buyers\Domain\Repository\BuyerRepositoryInterface;
use App\Buyers\Infrastructure\Adapters\UserAdapter;
use App\Shared\Infrastructure\Helper\ResponseMessage;
use Symfony\Component\HttpFoundation\JsonResponse;

class BuyerUpdate
{
    public function __construct(
        private readonly BuyerRepositoryInterface $buyerRepository,
        private readonly UserAdapter $userAdapter)
    {
    }

    public function update(array $buyer, string $requestUserId): JsonResponse
    {
        $repositoryUserId = $buyer[0]->getUser()->getId();

        if ($requestUserId !== $repositoryUserId) {
            $newUserId = $this->userAdapter->importUser($requestUserId);
            $buyer[0]->setUser($newUserId);
            $this->buyerRepository->update();
        }

        return new JsonResponse([
            'message' => ResponseMessage::UPDATE_RECORD,
        ], 200);
    }
}
