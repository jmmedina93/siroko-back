<?php

namespace App\CartContext\Application\Command;

use App\CartContext\Domain\ValueObject\ProductId;

class RemoveProductFromCartCommand
{
    public function __construct(
        public readonly string $cartId,
        public readonly ProductId $productId
    ) {}
}
