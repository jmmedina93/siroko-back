<?php

namespace App\Tests\OrderContext\Domain\ValueObject;

use App\CartContext\Domain\ValueObject\ProductId;
use App\OrderContext\Domain\ValueObject\OrderItem;
use PHPUnit\Framework\TestCase;

class OrderItemTest extends TestCase
{
    public function test_create_valid_order_item(): void
    {
        $item = new OrderItem(new ProductId('product-1'), 3);

        $this->assertSame('product-1', (string) $item->productId());
        $this->assertSame(3, $item->quantity());
    }

    public function test_quantity_cannot_be_less_than_1(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new OrderItem(new ProductId('product-1'), 0);
    }
}
