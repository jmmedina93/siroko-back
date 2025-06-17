<?php

namespace App\OrderContext\Domain\ValueObject;

use App\CartContext\Domain\ValueObject\ProductId;

class OrderItem
{
    public function __construct(
        private readonly ProductId $productId,
        private readonly int $quantity
    ) {
        if ($quantity < 1) {
            throw new \InvalidArgumentException('Quantity must be at least 1');
        }
    }

    public function productId(): ProductId
    {
        return $this->productId;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }
}
