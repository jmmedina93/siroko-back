<?php

namespace App\OrderContext\Application\Query;

class GetOrderQuery
{
    public function __construct(public readonly string $orderId) {}
}
