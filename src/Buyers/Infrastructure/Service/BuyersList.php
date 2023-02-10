<?php

namespace App\Buyers\Infrastructure\Service;

use App\Buyers\Domain\Repository\BuyerRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BuyersList extends AbstractController
{
    public function __construct(private readonly BuyerRepositoryInterface $buyerRepository)
    {
    }

    public function output(): JsonResponse
    {
        $buyers = $this->buyerRepository->getAllRecords();
        return $this->json($buyers);
    }
}
