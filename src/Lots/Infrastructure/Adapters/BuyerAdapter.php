<?php

namespace App\Lots\Infrastructure\Adapters;

use App\Buyers\Infrastructure\API\BuyerApi;
use Symfony\Component\HttpFoundation\JsonResponse;

class BuyerAdapter
{
    public function __construct(private readonly BuyerApi $buyerApi)
    {
    }

    public function setBuyer(string $lotId, string $userId): JsonResponse
    {
        return $this->buyerApi->setBuyer($lotId, $userId);
    }
}
