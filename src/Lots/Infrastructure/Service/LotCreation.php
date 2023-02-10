<?php

namespace App\Lots\Infrastructure\Service;

use App\Lots\Domain\Factory\LotFactory;
use App\Lots\Domain\Repository\LotRepositoryInterface;
use App\Lots\Infrastructure\Adapters\UserAdapter;
use App\Shared\Infrastructure\Helper\ResponseMessage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use TypeError;

class LotCreation
{
    public function __construct(
        private readonly LotFactory $lotFactory,
        private readonly LotRepositoryInterface $lotRepository,
        private readonly UserAdapter $userAdapter,
        private readonly ImageHandler $imageHandler)
    {
    }

    public function createLot(Request $request): JsonResponse
    {
        $userId = $request->get('user_id');
        $shortName = $request->get('short_name');
        $price = $request->get('price');
        $description = $request->get('description');
        $uploadFile = $request->files->get('lot_image');
        $end_trade_time = $request->get('end_trade_time');

        if (!$userId || !$shortName || !$price || !$description || !$uploadFile || !$end_trade_time) {
            return new JsonResponse([
                'error' => ResponseMessage::PARAMS_ERROR,
            ], 400);
        }

        $user = $this->userAdapter->getUserData($userId);
        $image_url = $this->imageHandler->handle($uploadFile);

        try {
            $lot = $this->lotFactory->create($user, $shortName, $price, $description, $image_url, $end_trade_time);
            $this->lotRepository->add($lot);
        } catch (TypeError $error) {
            return new JsonResponse([
                'error' => $error->getMessage(),
            ], 500);
        }

        return new JsonResponse([
            'message' => ResponseMessage::ADD_RECORD,
        ], 200);
    }
}
