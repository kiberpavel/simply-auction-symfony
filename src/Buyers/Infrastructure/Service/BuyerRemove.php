<?php

namespace App\Buyers\Infrastructure\Service;

use App\Buyers\Domain\Repository\BuyerRepositoryInterface;
use App\Shared\Infrastructure\Helper\ResponseMessage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BuyerRemove
{
    public function __construct(private readonly BuyerRepositoryInterface $buyerRepository)
    {
    }

    public function remove(Request $request): JsonResponse
    {
        $id = $request->get('id');

        if (!$id) {
            return new JsonResponse([
                'error' => ResponseMessage::PARAMS_ERROR,
            ], 400);
        }

        try {
            $lot = $this->buyerRepository->findById($id);
            $this->buyerRepository->remove($lot);
        } catch (\TypeError $error) {
            return new JsonResponse([
                'error' => $error->getMessage(),
            ], 500);
        }

        return new JsonResponse([
            'message' => ResponseMessage::REMOVE_RECORD,
        ], 200);
    }
}
