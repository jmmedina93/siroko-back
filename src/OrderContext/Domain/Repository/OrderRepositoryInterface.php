<?php

namespace App\OrderContext\Domain\Repository;

use App\OrderContext\Domain\Entity\Order;

interface OrderRepositoryInterface
{
    public function save(Order $order): void;
}
