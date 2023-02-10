<?php

namespace App\Lots\Infrastructure\Service;

use App\Lots\Domain\Repository\LotRepositoryInterface;
use App\Shared\Infrastructure\Helper\ResponseMessage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class LotRemove
{
    public function __construct(private readonly LotRepositoryInterface $lotRepository)
    {
    }

    public function removeLot(Request $request): JsonResponse
    {
        $id = $request->get('id');

        if (!$id) {
            return new JsonResponse([
                'error' => ResponseMessage::PARAMS_ERROR,
            ], 400);
        }

        try {
            $lot = $this->lotRepository->findById($id);
            $this->lotRepository->remove($lot);
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
