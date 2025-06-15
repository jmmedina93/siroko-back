<?php

namespace App\CartContext\Infrastructure\Framework\Symfony\Controller;

use App\CartContext\Application\Command\AddProductToCartCommand;
use App\CartContext\Application\Command\AddProductToCartHandler;
use App\CartContext\Domain\ValueObject\ProductId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    public function __construct(
        private readonly AddProductToCartHandler $handler
    ) {}

    #[Route('/api/cart/add', name: 'api_cart_add', methods: ['POST'])]
    public function addProduct(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['cartId'], $data['productId'], $data['quantity'])) {
            return $this->json(['error' => 'Invalid payload'], 400);
        }

        try {
            $command = new AddProductToCartCommand(
                $data['cartId'],
                new ProductId($data['productId']),
                (int) $data['quantity']
            );

            $this->handler->__invoke($command);

            return $this->json(['status' => 'Product added to cart']);
        } catch (\Throwable $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }
}
