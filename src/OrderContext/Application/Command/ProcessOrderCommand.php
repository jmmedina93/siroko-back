<?php

namespace App\OrderContext\Application\Command;

class ProcessOrderCommand
{
    public function __construct(
        public readonly string $cartId
    ) {}
}
