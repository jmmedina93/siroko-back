<?php

namespace App\CartContext\Application\Query;

use App\CartContext\Domain\Repository\CartRepositoryInterface;
use RuntimeException;

class GetCartHandler
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository
    ) {}

    public function __invoke(GetCartQuery $query): array
    {
        $cart = $this->cartRepository->getById($query->cartId);

        if (!$cart) {
            throw new RuntimeException('Cart not found.');
        }

        // Transformar el carrito a array simple para JSON
        $items = [];
        foreach ($cart->items() as $item) {
            $items[] = [
                'productId' => (string) $item->productId(),
                'quantity' => $item->quantity(),
            ];
        }

        return [
            'cartId' => $cart->id(),
            'items' => $items,
        ];
    }
}
