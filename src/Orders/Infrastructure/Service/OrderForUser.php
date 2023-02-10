<?php

namespace App\Orders\Infrastructure\Service;

use App\Orders\Domain\Entity\Order;
use App\Orders\Domain\Repository\OrderRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrderForUser extends AbstractController
{
    public function __construct(private readonly OrderRepositoryInterface $orderRepository)
    {
    }

    public function output(string $userId): JsonResponse
    {
        $orders = $this->orderRepository->getAllRecords();
        $res = [];
        foreach ($orders as $order) {
            $repositoryUserId = $order->getBuyer()->getUser()->getId();
            $status = $order->getStatus();
            if ($repositoryUserId === $userId && Order::STATUS_NOT_PAID === $status) {
                $res[] = $order;
            }
        }

        return $this->json(['data' => $res,
            'count' => count($res), ]);
    }
}
