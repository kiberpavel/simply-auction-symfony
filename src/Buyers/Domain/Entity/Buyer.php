<?php

namespace App\Buyers\Domain\Entity;

use App\Lots\Domain\Entity\Lot;
use App\Shared\Domain\Service\UlidService;
use App\Users\Domain\Entity\User;

class Buyer
{
    private string $id;
    private Lot $lot;
    private User $user;

    public function __construct(Lot $lot, User $user)
    {
        $this->id = UlidService::generate();
        $this->lot = $lot;
        $this->user = $user;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLot(): Lot
    {
        return $this->lot;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
