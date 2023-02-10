<?php

namespace App\Orders\Infrastructure\Service;

use App\Orders\Domain\Repository\OrderRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrderList extends AbstractController
{
    public function __construct(private readonly OrderRepositoryInterface $orderRepository)
    {
    }

    public function output(): JsonResponse
    {
        $orders = $this->orderRepository->getAllRecords();
        return $this->json(['data' => $orders]);
    }
}
