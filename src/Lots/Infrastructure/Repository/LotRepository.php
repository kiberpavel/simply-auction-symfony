<?php

namespace App\Lots\Infrastructure\Repository;

use App\Lots\Domain\Entity\Lot;
use App\Lots\Domain\Repository\LotRepositoryInterface;
use App\Shared\Domain\Security\AuthUserInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LotRepository extends ServiceEntityRepository implements LotRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lot::class);
    }

    public function add(Lot $lot): void
    {
        $this->_em->persist($lot);
        $this->_em->flush();
    }

    public function remove(Lot $lot): void
    {
        $this->_em->remove($lot);
        $this->_em->flush();
    }

    public function update(): void
    {
        $this->_em->flush();
    }

    public function getAllRecords(): ?array
    {
        return $this->findAll();
    }

    public function findById(string $id): ?Lot
    {
        return $this->find($id);
    }

    public function getUserRecords(AuthUserInterface $user): array
    {
        return $this->findBy(['user' => $user]);
    }
}
