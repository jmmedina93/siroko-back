<?php

namespace App\CartContext\Application\Command;

use App\CartContext\Domain\Repository\CartRepositoryInterface;

class RemoveProductFromCartHandler
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository
    ) {}

    public function __invoke(RemoveProductFromCartCommand $command): void
    {
        $cart = $this->cartRepository->getById($command->cartId);
        $cart->removeProduct($command->productId);
        $this->cartRepository->save($cart);
    }
}
