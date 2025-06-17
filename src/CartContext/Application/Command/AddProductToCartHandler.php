<?php

namespace App\CartContext\Application\Command;

use App\CartContext\Domain\Model\Cart;
use App\CartContext\Domain\Repository\CartRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class AddProductToCartHandler
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository
    ) {}

    public function __invoke(AddProductToCartCommand $command): array
    {
        $cartId = $command->cartId;

        if (!$cartId || !$this->cartRepository->exists($cartId)) {
            $cartId = Uuid::v4()->toRfc4122();
            $cart = new Cart($cartId);
        } else {
            $cart = $this->cartRepository->getById($cartId);
        }

        $cart->addProduct($command->productId, $command->quantity);
        $this->cartRepository->save($cart);

        return [
            'cartId' => $cart->id(),
            'items' => array_map(fn($item) => [
                'productId' => (string) $item->productId(),
                'quantity' => $item->quantity(),
            ], $cart->items()),
        ];
    }
}
