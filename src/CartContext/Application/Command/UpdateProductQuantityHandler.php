<?php

namespace App\CartContext\Application\Command;

use App\CartContext\Domain\Repository\CartRepositoryInterface;

class UpdateProductQuantityHandler
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository
    ) {}

    public function __invoke(UpdateProductQuantityCommand $command): void
    {
        if ($command->quantity < 1) {
            throw new \InvalidArgumentException('Quantity must be at least 1. To remove a product, use the remove endpoint.');
        }

        $cart = $this->cartRepository->getById($command->cartId);
        $cart->updateProductQuantity($command->productId, $command->quantity);
        $this->cartRepository->save($cart);
    }
}
