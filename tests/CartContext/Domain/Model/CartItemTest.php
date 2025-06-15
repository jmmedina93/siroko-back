<?php

namespace App\Tests\CartContext\Domain\Model;

use App\CartContext\Domain\Model\CartItem;
use App\CartContext\Domain\ValueObject\ProductId;
use PHPUnit\Framework\TestCase;

class CartItemTest extends TestCase
{
    public function test_create_cart_item(): void
    {
        $productId = new ProductId('prod-1');
        $item = new CartItem($productId, 2);

        $this->assertSame(2, $item->quantity());
        $this->assertTrue($item->productId()->equals($productId));
    }

    public function test_increase_quantity(): void
    {
        $item = new CartItem(new ProductId('p'), 1);
        $item->increaseQuantity(3);

        $this->assertSame(4, $item->quantity());
    }

    public function test_update_quantity(): void
    {
        $item = new CartItem(new ProductId('p'), 1);
        $item->updateQuantity(5);

        $this->assertSame(5, $item->quantity());
    }

    public function test_negative_quantity_throws_exception(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new CartItem(new ProductId('p'), 0);
    }
}
