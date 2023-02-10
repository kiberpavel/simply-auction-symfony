<?php

namespace App\Orders\Infrastructure\Service;

use App\Orders\Domain\Entity\Order;
use App\Orders\Domain\Repository\OrderRepositoryInterface;
use App\Shared\Infrastructure\Helper\ResponseMessage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OrderPay
{
    public function __construct(private readonly OrderRepositoryInterface $orderRepository)
    {
    }

    public function set(Request $request): JsonResponse
    {
        $result = $request->get('orders');

        foreach ($result as $res) {
            $order = $this->orderRepository->findById($res);
            $order->setStatus(Order::STATUS_PAID);
            $this->orderRepository->update();
        }

        return new JsonResponse(['message' => ResponseMessage::SUCCESS_PAY]);
    }
}
