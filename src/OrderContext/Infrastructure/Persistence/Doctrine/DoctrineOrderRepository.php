<?php

namespace App\OrderContext\Infrastructure\Persistence\Doctrine;

use App\OrderContext\Domain\Entity\Order as DomainOrder;
use App\OrderContext\Domain\Repository\OrderRepositoryInterface;
use App\OrderContext\Infrastructure\Persistence\Doctrine\Entity\DoctrineOrder;
use App\OrderContext\Infrastructure\Persistence\Doctrine\Entity\DoctrineOrderItem;
use App\CartContext\Domain\ValueObject\ProductId;
use App\OrderContext\Domain\ValueObject\OrderItem;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineOrderRepository implements OrderRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {}

    public function save(DomainOrder $order): void
    {
        $entity = new DoctrineOrder($order->id(), $order->cartId());

        foreach ($order->items() as $item) {
            $entity->addItem(new DoctrineOrderItem(
                (string) $item->productId(),
                $item->quantity()
            ));
        }

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function getById(string $orderId): ?DomainOrder
    {
        /** @var DoctrineOrder|null $entity */
        $entity = $this->em->getRepository(DoctrineOrder::class)->find($orderId);

        if (!$entity) {
            return null;
        }

        $items = [];
        foreach ($entity->getItems() as $item) {
            $items[] = new OrderItem(
                new ProductId($item->getProductId()),
                $item->getQuantity()
            );
        }

        return new DomainOrder(
            $entity->getId(),
            $entity->getCartId(),
            $items,
            $entity->getCreatedAt()
        );
    }
}
