<?php

namespace App\OrderContext\Application\Query;

use App\OrderContext\Domain\Repository\OrderRepositoryInterface;
use RuntimeException;

class GetOrderHandler
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository
    ) {}

    public function __invoke(GetOrderQuery $query): array
    {
        $order = $this->orderRepository->getById($query->orderId);

        if (!$order) {
            throw new RuntimeException('Order not found');
        }

        return [
            'orderId' => $order->id(),
            'cartId' => $order->cartId(),
            'createdAt' => $order->createdAt()->format('c'),
            'items' => array_map(fn ($item) => [
                'productId' => (string) $item->productId(),
                'quantity' => $item->quantity(),
            ], $order->items())
        ];
    }
}
