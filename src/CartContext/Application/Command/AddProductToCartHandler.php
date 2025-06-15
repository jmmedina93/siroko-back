<?php

namespace App\CartContext\Application\Command;

use App\CartContext\Domain\Repository\CartRepositoryInterface;
use App\CartContext\Domain\Model\Cart;

class AddProductToCartHandler
{
    public function __construct(
        private CartRepositoryInterface $cartRepository
    ) {}

    public function __invoke(AddProductToCartCommand $command): void
    {
        if ($this->cartRepository->exists($command->cartId)) {
            $cart = $this->cartRepository->getById($command->cartId);
        } else {
            $cart = new Cart($command->cartId);
        }

        $cart->addProduct($command->productId, $command->quantity);

        $this->cartRepository->save($cart);
    }
}
