<?php

namespace App\Lots\Infrastructure\Service;

use App\Lots\Domain\Entity\Lot;
use App\Lots\Domain\Repository\LotRepositoryInterface;
use App\Shared\Infrastructure\Helper\ResponseMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class LotEdit extends AbstractController
{
    public function __construct(
        private readonly LotRepositoryInterface $lotRepository,
        private readonly ImageHandler $imageHandler)
    {
    }

    public function editLot(Request $request): JsonResponse
    {
        $counter = 0;
        $params = ['short_name', 'status', 'price', 'description', 'lot_image', 'end_trade_time'];
        $id = $request->get('id');

        if (!$id) {
            return new JsonResponse([
                'error' => ResponseMessage::PARAMS_ERROR,
            ], 400);
        }
        $lot = $this->lotRepository->findById($id);

        if (!$lot) {
            return new JsonResponse([
                'error' => ResponseMessage::NOT_FOUND,
            ], 404);
        }

        foreach ($params as $param) {
            $data = $request->get($param);

            if ('lot_image' === $param) {
                $uploadFile = $request->files->get($param);
                if ($uploadFile) {
                    $data = $this->imageHandler->handle($uploadFile);
                }
            }
            if ($data) {
                $this->chooseSetter($param, $lot, $data);
                ++$counter;
            }
        }

        if ($counter > 0) {
            $this->lotRepository->update();
        }

        return new JsonResponse([
            'message' => ResponseMessage::UPDATE_RECORD,
        ], 200);
    }

    private function chooseSetter(string $param, Lot $lot, mixed $data): void
    {
        switch ($param) {
            case 'short_name':
                $lot->setShortName($data);
                break;
            case 'status':
                $lot->setStatus($data);
                break;
            case 'price':
                $lot->setPrice($data);
                break;
            case 'description':
                $lot->setDescription($data);
                break;
            case 'lot_image':
                $lot->setImageUrl($data);
                break;
            case 'end_trade_time':
                $lot->setEndTradeTime($data);
        }
    }
}
