<?php

namespace App\OrderContext\Infrastructure\Framework\Symfony\Controller;

use App\OrderContext\Application\Command\ProcessOrderCommand;
use App\OrderContext\Application\Command\ProcessOrderHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/api/order/checkout', name: 'api_order_checkout', methods: ['POST'])]
    public function checkout(Request $request, ProcessOrderHandler $handler): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['cartId'])) {
            return $this->json(['error' => 'cartId is required'], 400);
        }

        try {
            $command = new ProcessOrderCommand($data['cartId']);
            $orderId = $handler->__invoke($command);

            return $this->json([
                'status' => 'Order created successfully',
                'orderId' => $orderId
            ]);
        } catch (\Throwable $e) {
            return $this->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}
