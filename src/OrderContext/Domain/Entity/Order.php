<?php

namespace App\OrderContext\Domain\Entity;

use App\OrderContext\Domain\ValueObject\OrderItem;

class Order
{
    /**
     * @param OrderItem[] $items
     */
    public function __construct(
        private readonly string $id,
        private readonly string $cartId,
        private readonly array $items,
        private readonly \DateTimeImmutable $createdAt = new \DateTimeImmutable()
    ) {
        if (empty($items)) {
            throw new \InvalidArgumentException('Order must contain at least one item');
        }
    }

    public function id(): string
    {
        return $this->id;
    }

    public function cartId(): string
    {
        return $this->cartId;
    }

    /**
     * @return OrderItem[]
     */
    public function items(): array
    {
        return $this->items;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
