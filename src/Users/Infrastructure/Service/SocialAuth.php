<?php

namespace App\Users\Infrastructure\Service;

use App\Users\Domain\Factory\UserFactory;
use App\Users\Domain\Service\SocialAuthInterface;
use App\Users\Infrastructure\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SocialAuth implements SocialAuthInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserFactory $userFactory,
        private JWTTokenManagerInterface $tokenManager)
    {
    }

    public function auth(Request $request): JsonResponse
    {
        $email = $request->get('email');
        $result = $this->userRepository->findByEmail($email);
        $user = $this->userFactory->create($email, null);

        if (!$result) {
            $this->userRepository->add($user);
        }

        $token = $this->tokenManager->create($user);

        return new JsonResponse([
            'token' => $token,
        ], 200);
    }
}
