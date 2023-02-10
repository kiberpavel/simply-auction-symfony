<?php

namespace App\Orders\Domain\Entity;

use App\Buyers\Domain\Entity\Buyer;
use App\Orders\Domain\Service\DateTimeService;
use App\Shared\Domain\Service\UlidService;

class Order
{
    public const STATUS_PAID = 'paid';
    public const STATUS_NOT_PAID = 'not_paid';

    private string $id;
    private Buyer $buyer;
    private string $status;
    private \DateTimeImmutable $end_time_for_pay;

    public function __construct(Buyer $buyer)
    {
        $this->id = UlidService::generate();
        $this->buyer = $buyer;
        $this->status = self::STATUS_NOT_PAID;
        $this->end_time_for_pay = new \DateTimeImmutable(DateTimeService::generate());
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getBuyer(): Buyer
    {
        return $this->buyer;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getEndTimeForPay(): \DateTimeImmutable
    {
        return $this->end_time_for_pay;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
