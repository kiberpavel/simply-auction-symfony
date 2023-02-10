<?php

namespace App\Buyers\Infrastructure\Service;

use App\Buyers\Domain\Factory\BuyerFactory;
use App\Buyers\Domain\Repository\BuyerRepositoryInterface;
use App\Lots\Domain\Entity\Lot;
use App\Shared\Infrastructure\Helper\ResponseMessage;
use App\Users\Domain\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;

class BuyerCreation
{
    public function __construct(
        private readonly BuyerFactory $buyerFactory,
        private readonly BuyerRepositoryInterface $buyerRepository)
    {
    }

    public function create(Lot $lot, User $user): JsonResponse
    {
        $buyer = $this->buyerFactory->create($lot, $user);

        $this->buyerRepository->add($buyer);

        return new JsonResponse([
            'message' => ResponseMessage::ADD_RECORD,
        ], 200);
    }
}
