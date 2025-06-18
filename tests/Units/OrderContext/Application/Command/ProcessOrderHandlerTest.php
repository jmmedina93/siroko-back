<?php

namespace App\Tests\Units\OrderContext\Application\Command;

use App\CartContext\Domain\Model\Cart;
use App\CartContext\Domain\Model\CartItem;
use App\CartContext\Domain\Repository\CartRepositoryInterface;
use App\CartContext\Domain\ValueObject\ProductId;
use App\OrderContext\Application\Command\ProcessOrderCommand;
use App\OrderContext\Application\Command\ProcessOrderHandler;
use App\OrderContext\Domain\Repository\OrderRepositoryInterface;
use PHPUnit\Framework\TestCase;

class ProcessOrderHandlerTest extends TestCase
{
    public function test_it_fails_with_empty_cart(): void
    {
        $cart = new Cart('cart-empty', []); // carrito vacío

        $cartRepository = $this->createMock(CartRepositoryInterface::class);
        $cartRepository->method('getById')->willReturn($cart);

        $orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $orderRepository->expects($this->never())->method('save');

        $handler = new ProcessOrderHandler($cartRepository, $orderRepository);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Handler error: Cannot process an order with an empty cart');

        $handler->__invoke(new ProcessOrderCommand('cart-empty'));
    }
}
