<?php

namespace App\Buyers\Infrastructure\Repository;

use App\Buyers\Domain\Entity\Buyer;
use App\Buyers\Domain\Repository\BuyerRepositoryInterface;
use App\Lots\Domain\Entity\Lot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BuyerRepository extends ServiceEntityRepository implements BuyerRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Buyer::class);
    }

    public function add(Buyer $buyer): void
    {
        $this->_em->persist($buyer);
        $this->_em->flush();
    }

    public function remove(Buyer $buyer): void
    {
        $this->_em->remove($buyer);
        $this->_em->flush();
    }

    public function update(): void
    {
        $this->_em->flush();
    }

    public function findById(string $id): ?Buyer
    {
        return $this->find($id);
    }

    public function getAllRecords(): ?array
    {
        return $this->findAll();
    }

    public function getRecordByLot(Lot $lot): array
    {
        return $this->findBy(['lot' => $lot]);
    }
}
