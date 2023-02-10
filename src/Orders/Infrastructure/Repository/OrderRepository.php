<?php

namespace App\Orders\Infrastructure\Repository;

use App\Buyers\Domain\Entity\Buyer;
use App\Orders\Domain\Entity\Order;
use App\Orders\Domain\Repository\OrderRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrderRepository extends ServiceEntityRepository implements OrderRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function add(Order $order): void
    {
        $this->_em->persist($order);
        $this->_em->flush();
    }

    public function remove(Order $order): void
    {
        $this->_em->remove($order);
        $this->_em->flush();
    }

    public function getAllRecords(): ?array
    {
        return $this->findAll();
    }

    public function findById(string $id): ?Order
    {
        return $this->find($id);
    }

    public function findByBuyer(Buyer $buyer): array
    {
        return $this->findBy(['buyer' => $buyer]);
    }

    public function update(): void
    {
        $this->_em->flush();
    }

}
