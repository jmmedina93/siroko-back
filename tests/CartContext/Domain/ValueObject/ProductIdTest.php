<?php

namespace App\Tests\CartContext\Domain\ValueObject;

use App\CartContext\Domain\ValueObject\ProductId;
use PHPUnit\Framework\TestCase;

class ProductIdTest extends TestCase
{
    public function test_can_create_product_id(): void
    {
        $productId = new ProductId('abc-123');

        $this->assertSame('abc-123', $productId->value());
        $this->assertSame('abc-123', (string) $productId);
    }

    public function test_equals_method(): void
    {
        $id1 = new ProductId('xyz');
        $id2 = new ProductId('xyz');
        $id3 = new ProductId('different');

        $this->assertTrue($id1->equals($id2));
        $this->assertFalse($id1->equals($id3));
    }

    public function test_cannot_be_empty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new ProductId('');
    }
}
