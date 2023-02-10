<?php

namespace App\Lots\Infrastructure\Service;

use App\Lots\Domain\Repository\LotRepositoryInterface;
use App\Shared\Domain\Security\UserFetcherInterface;
use App\Shared\Infrastructure\Helper\ResponseMessage;
use App\Users\Domain\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;

class LotsList extends AbstractController
{
    public function __construct(
        private readonly LotRepositoryInterface $lotRepository,
        private readonly UserFetcherInterface $userFetcher,
        private readonly Security $security)
    {
    }

    public function outputLots(): JsonResponse
    {
        if (!$this->security->getUser()) {
            return $this->json($this->lotRepository->getAllRecords());
        }

        $user = $this->userFetcher->getAuthUser();
        $role = $user->getRoles()[0];

        $lots = $this->lotRepository->getAllRecords();

        if (User::ROLE_VENDOR === $role) {
            $lots = $this->lotRepository->getUserRecords($user);
        }

        return $this->json($lots);
    }
}
