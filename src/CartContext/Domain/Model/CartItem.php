<?php

namespace App\CartContext\Domain\Model;

use App\CartContext\Domain\ValueObject\ProductId;

class CartItem
{
    public function __construct(
        private ProductId $productId,
        private int $quantity
    ) {
        $this->assertQuantityIsPositive($quantity);
    }

    /**
     * Devuelve el identificador del producto asociado a esta línea del carrito.
     */
    public function productId(): ProductId
    {
        return $this->productId;
    }

    /**
     * Devuelve la cantidad actual de este producto en el carrito.
     */
    public function quantity(): int
    {
        return $this->quantity;
    }

    /**
     * Aumenta la cantidad del producto en el carrito en la cantidad indicada.
     */
    public function increaseQuantity(int $amount): void
    {
        $this->assertQuantityIsPositive($amount);
        $this->quantity += $amount;
    }

    /**
     * Establece una nueva cantidad absoluta para este producto.
     */
    public function updateQuantity(int $newQuantity): void
    {
        $this->assertQuantityIsPositive($newQuantity);
        $this->quantity = $newQuantity;
    }

    /**
     * Valida que la cantidad proporcionada sea mayor que cero.
     */
    private function assertQuantityIsPositive(int $quantity): void
    {
        if ($quantity < 1) {
            throw new \InvalidArgumentException('Quantity must be greater than zero.');
        }
    }
}
