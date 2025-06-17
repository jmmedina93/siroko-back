<?php

namespace App\OrderContext\Application\Command;

use App\CartContext\Domain\Repository\CartRepositoryInterface;
use App\OrderContext\Domain\Entity\Order;
use App\OrderContext\Domain\Repository\OrderRepositoryInterface;
use App\OrderContext\Domain\ValueObject\OrderItem;
use Symfony\Component\Uid\Uuid;

class ProcessOrderHandler
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository,
        private readonly OrderRepositoryInterface $orderRepository
    ) {}

    public function __invoke(ProcessOrderCommand $command): string
    {
        try {
            $cart = $this->cartRepository->getById($command->cartId);

            if (empty($cart->items())) {
                throw new \DomainException('Cannot process an order with an empty cart');
            }

            $items = array_map(
                fn($item) => new OrderItem($item->productId(), $item->quantity()),
                $cart->items()
            );

            $orderId = Uuid::v4()->toRfc4122();
            $order = new Order($orderId, $cart->id(), $items);

            $this->orderRepository->save($order);

            return $orderId;
        } catch (\Throwable $e) {
            throw new \RuntimeException('Handler error: ' . $e->getMessage(), 0, $e);
        }
    }
}
