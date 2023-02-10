<?php

namespace App\Users\Infrastructure\API;

use App\Users\Domain\Entity\User;
use App\Users\Infrastructure\Repository\UserRepository;

class UserApi
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function getUserData(string $id): User
    {
        return $this->userRepository->findById($id);
    }
}
