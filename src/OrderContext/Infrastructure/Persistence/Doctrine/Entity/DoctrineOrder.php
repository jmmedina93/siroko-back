<?php

namespace App\OrderContext\Infrastructure\Persistence\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'orders')]
class DoctrineOrder
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36)]
    private string $id;

    #[ORM\Column(type: 'string', length: 36)]
    private string $cartId;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\OneToMany(mappedBy: 'order', targetEntity: DoctrineOrderItem::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $items;

    public function __construct(string $id, string $cartId)
    {
        $this->id = $id;
        $this->cartId = $cartId;
        $this->createdAt = new \DateTimeImmutable();
        $this->items = new ArrayCollection();
    }

    public function addItem(DoctrineOrderItem $item): void
    {
        $item->setOrder($this);
        $this->items->add($item);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCartId(): string
    {
        return $this->cartId;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return DoctrineOrderItem[]
     */
    public function getItems(): iterable
    {
        return $this->items;
    }
}
