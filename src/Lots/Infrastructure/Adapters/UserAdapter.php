<?php

namespace App\Lots\Infrastructure\Adapters;

use App\Users\Domain\Entity\User;
use App\Users\Infrastructure\API\UserApi;

class UserAdapter
{
    public function __construct(private readonly UserApi $userApi)
    {
    }

    public function getUserData(string $id): User
    {
        return $this->userApi->getUserData($id);
    }
}
