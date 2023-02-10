<?php

namespace App\Buyers\Infrastructure\Service;

use App\Buyers\Domain\Repository\BuyerRepositoryInterface;
use App\Shared\Infrastructure\Helper\ResponseMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BuyerCurrent extends AbstractController
{
    public function __construct(private readonly BuyerRepositoryInterface $buyerRepository)
    {
    }

    public function output(Request $request): JsonResponse
    {
        $id = $request->query->get('id');

        $buyer = $this->buyerRepository->findById($id);

        if (is_null($buyer)) {
            return  $this->json(['error' => ResponseMessage::NOT_FOUND]);
        }

        return $this->json(['data' => $buyer]);
    }
}
