<?php

namespace App\Tests\OrderContext\Domain\Entity;

use App\CartContext\Domain\ValueObject\ProductId;
use App\OrderContext\Domain\Entity\Order;
use App\OrderContext\Domain\ValueObject\OrderItem;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function test_create_valid_order(): void
    {
        $items = [
            new OrderItem(new ProductId('product-1'), 2),
            new OrderItem(new ProductId('product-2'), 1)
        ];

        $order = new Order('order-123', 'cart-123', $items);

        $this->assertSame('order-123', $order->id());
        $this->assertSame('cart-123', $order->cartId());
        $this->assertCount(2, $order->items());
        $this->assertInstanceOf(\DateTimeImmutable::class, $order->createdAt());
    }

    public function test_order_must_have_at_least_one_item(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Order('order-123', 'cart-123', []);
    }
}
