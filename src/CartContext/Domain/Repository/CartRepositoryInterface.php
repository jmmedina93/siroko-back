<?php

namespace App\CartContext\Domain\Repository;

use App\CartContext\Domain\Model\Cart;

interface CartRepositoryInterface
{

    public function save(Cart $cart): void;

    public function getById(string $id): Cart;
    
    public function exists(string $id): bool;
}
