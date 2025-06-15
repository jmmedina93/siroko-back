<?php

namespace App\CartContext\Infrastructure\Persistence\Doctrine;

use App\CartContext\Domain\Model\Cart as DomainCart;
use App\CartContext\Domain\Model\CartItem as DomainCartItem;
use App\CartContext\Domain\Repository\CartRepositoryInterface;
use App\CartContext\Domain\ValueObject\ProductId;
use App\CartContext\Infrastructure\Persistence\Doctrine\Entity\Cart as DoctrineCart;
use App\CartContext\Infrastructure\Persistence\Doctrine\Entity\CartItem as DoctrineCartItem;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use RuntimeException;

class DoctrineCartRepository implements CartRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {}

    public function save(DomainCart $cart): void
    {
        $entity = new DoctrineCart($cart->id());

        foreach ($cart->items() as $item) {
            $entity->addItem(new DoctrineCartItem(
                (string) $item->productId(),
                $item->quantity()
            ));
        }

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function getById(string $id): DomainCart
    {
        $entity = $this->em->getRepository(DoctrineCart::class)->find($id);

        if (!$entity) {
            throw new RuntimeException("Cart not found");
        }

        $cart = new DomainCart($entity->getId());

        foreach ($entity->getItems() as $item) {
            $cart->addProduct(
                new ProductId($item->getProductId()),
                $item->getQuantity()
            );
        }

        return $cart;
    }

    public function exists(string $id): bool
    {
        return $this->em->getRepository(DoctrineCart::class)->find($id) !== null;
    }
}
