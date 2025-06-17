<?php

namespace App\OrderContext\Infrastructure\Persistence\Doctrine;

use App\OrderContext\Domain\Entity\Order as DomainOrder;
use App\OrderContext\Domain\Repository\OrderRepositoryInterface;
use App\OrderContext\Infrastructure\Persistence\Doctrine\Entity\DoctrineOrder;
use App\OrderContext\Infrastructure\Persistence\Doctrine\Entity\DoctrineOrderItem;
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
}
