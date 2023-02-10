<?php

namespace App\Orders\Infrastructure\Service;

use App\Orders\Domain\Repository\OrderRepositoryInterface;
use App\Shared\Infrastructure\Helper\ResponseMessage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OrderRemove
{
    public function __construct(private readonly OrderRepositoryInterface $orderRepository)
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
            $order = $this->orderRepository->findById($id);
            $this->orderRepository->remove($order);
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
