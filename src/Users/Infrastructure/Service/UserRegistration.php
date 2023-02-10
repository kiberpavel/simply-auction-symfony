<?php

namespace App\Users\Infrastructure\Service;

use App\Shared\Domain\Service\ValidationErrorHandler;
use App\Shared\Infrastructure\Helper\ResponseMessage;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Infrastructure\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserRegistration
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserFactory $userFactory,
        private readonly ValidatorInterface $validator,
        private readonly ValidationErrorHandler $validationErrorHandler
    ) {
    }

    public function register(Request $request): JsonResponse
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $user = $this->userFactory->create($email, $password);
        $errors = $this->validator->validate($user);
        if (count($errors)) {
            return $this->validationErrorHandler->handle($errors);
        }

        $this->userRepository->add($user);

        return new JsonResponse([
            'message' => ResponseMessage::ADD_RECORD,
        ], 200);
    }
}
