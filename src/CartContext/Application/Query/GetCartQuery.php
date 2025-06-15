<?php

namespace App\CartContext\Application\Query;

class GetCartQuery
{
    public function __construct(
        public readonly string $cartId
    ) {}
}
