<?php

namespace App\Users\Domain\Entity;

use App\Shared\Domain\Security\AuthUserInterface;
use App\Shared\Domain\Service\UlidService;
use App\Users\Domain\Service\UserPasswordHasherInterface;
use App\Users\Infrastructure\Service\UserPasswordHasher;

class User implements AuthUserInterface
{
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_VENDOR = 'ROLE_VENDOR';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    private string $id;
    private string $email;
    private ?string $password = null;
    private string $role;

    /**
     * @param string $email
     * @param string $role
     */
    public function __construct(
        string $email,
        string $role,
    ) {
        $this->id = UlidService::generate();
        $this->email = $email;
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return [$this->role];
    }

    /**
     * @return void
     */
    public function eraseCredentials(): void
    {
    }

    /**
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @param string|null $password
     * @param UserPasswordHasher $passwordHasher
     * @return void
     */
    public function setPassword(?string $password, UserPasswordHasher $passwordHasher): void
    {
        is_null($password) ? $this->password = null : $this->password = $passwordHasher->hash($this, $password);
    }

    /**
     * @param string $role
     * @return void
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }
}
