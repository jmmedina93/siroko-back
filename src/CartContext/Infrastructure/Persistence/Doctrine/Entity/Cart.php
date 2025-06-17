<?php

namespace App\CartContext\Infrastructure\Persistence\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "cart")]
class Cart
{
    #[ORM\Id]
    #[ORM\Column(type: "string", length: 36)]
    private string $id;

    #[ORM\OneToMany(mappedBy: "cart", targetEntity: CartItem::class, cascade: ["persist", "remove"], orphanRemoval: true)]
    private Collection $items;

    public function __construct(string $id)
    {
        $this->id = $id;
        $this->items = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(CartItem $item): void
    {
        foreach ($this->items as $existing) {
            if ($existing->getProductId() === $item->getProductId()) {
                $existing->increaseQuantity($item->getQuantity());
                return;
            }
        }

        $item->setCart($this);
        $this->items->add($item);
    }

    public function removeItem(CartItem $item): void
    {
        $this->items->removeElement($item);
    }
}
