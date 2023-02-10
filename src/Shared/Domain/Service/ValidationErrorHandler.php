<?php

namespace App\Shared\Domain\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ValidationErrorHandler extends AbstractController
{
    public function handle(object $errors): JsonResponse
    {
        return $this->json($errors, 400);
    }
}
