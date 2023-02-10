<?php

namespace App\Users\Domain\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

interface SocialAuthInterface
{
    public function auth(Request $request): JsonResponse;
}
