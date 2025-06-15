<?php

namespace App\CartContext\Domain\Model;

use App\CartContext\Domain\ValueObject\ProductId;

class Cart
{
    /** @var CartItem[] */
    private array $items = [];

    public function __construct(
        private readonly string $id // puede ser UUID u otro VO más adelante
    ) {}

    /**
     * Devuelve el identificador del carrito.
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * Devuelve todos los ítems del carrito.
     *
     * @return CartItem[]
     */
    public function items(): array
    {
        return array_values($this->items);
    }

    /**
     * Añade un producto al carrito o incrementa su cantidad si ya existe.
     */
    public function addProduct(ProductId $productId, int $quantity): void
    {
        $key = $this->itemKey($productId);

        if (isset($this->items[$key])) {
            $this->items[$key]->increaseQuantity($quantity);
        } else {
            $this->items[$key] = new CartItem($productId, $quantity);
        }
    }

    /**
     * Actualiza la cantidad de un producto del carrito.
     */
    public function updateProductQuantity(ProductId $productId, int $newQuantity): void
    {
        $key = $this->itemKey($productId);

        if (!isset($this->items[$key])) {
            throw new \DomainException('Product not found in cart.');
        }

        $this->items[$key]->updateQuantity($newQuantity);
    }

    /**
     * Elimina un producto del carrito.
     */
    public function removeProduct(ProductId $productId): void
    {
        $key = $this->itemKey($productId);

        if (isset($this->items[$key])) {
            unset($this->items[$key]);
        }
    }

    /**
     * Calcula un identificador interno para indexar los ítems del carrito.
     */
    private function itemKey(ProductId $productId): string
    {
        return (string) $productId;
    }
}
