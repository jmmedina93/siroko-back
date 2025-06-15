<?php

namespace App\CartContext\Infrastructure\Framework\Symfony\Controller;

use App\CartContext\Application\Command\AddProductToCartCommand;
use App\CartContext\Application\Command\AddProductToCartHandler;
use App\CartContext\Domain\ValueObject\ProductId;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\CartContext\Application\Query\GetCartQuery;
use App\CartContext\Application\Query\GetCartHandler;
use Symfony\Component\HttpFoundation\Response;
use App\CartContext\Application\Command\UpdateProductQuantityCommand;
use App\CartContext\Application\Command\UpdateProductQuantityHandler;
use App\CartContext\Application\Command\RemoveProductFromCartCommand;
use App\CartContext\Application\Command\RemoveProductFromCartHandler;

class CartController extends AbstractController
{
    public function __construct(
        private readonly AddProductToCartHandler $handler
    ) {}

    #[Route('/api/cart/add', name: 'api_cart_add', methods: ['POST'])]
    public function addProduct(Request $request, AddProductToCartHandler $handler): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['productId'], $data['quantity'])) {
            return $this->json(['error' => 'Invalid payload'], 400);
        }

        try {
            $command = new AddProductToCartCommand(
                $data['cartId'] ?? null,
                new ProductId($data['productId']),
                (int) $data['quantity']
            );

            $result = $handler->__invoke($command);

            return $this->json($result);
        } catch (\Throwable $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    #[Route('/api/cart/{cartId}', name: 'api_cart_get', methods: ['GET'])]
    public function getCart(string $cartId, GetCartHandler $handler): JsonResponse
    {
        try {
            $result = $handler->__invoke(new GetCartQuery($cartId));

            return $this->json($result);
        } catch (\RuntimeException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $e) {
            return $this->json(['error' => 'Internal Server Error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/api/cart/update', name: 'api_cart_update', methods: ['PUT'])]
    public function updateProductQuantity(
        Request $request,
        UpdateProductQuantityHandler $handler
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['cartId'], $data['productId'], $data['quantity'])) {
            return $this->json(['error' => 'Invalid payload'], 400);
        }

        try {
            $command = new UpdateProductQuantityCommand(
                $data['cartId'],
                new ProductId($data['productId']),
                (int) $data['quantity']
            );

            $handler->__invoke($command);

            return $this->json(['status' => 'Quantity updated']);
        } catch (\InvalidArgumentException $e) {
            return $this->json(['error' => $e->getMessage()], 422);
        } catch (\Throwable $e) {
            return $this->json(['error' => 'Internal Server Error'], 500);
        }
    }
    #[Route('/api/cart/remove', name: 'api_cart_remove', methods: ['DELETE'])]
    public function removeProductFromCart(
        Request $request,
        RemoveProductFromCartHandler $handler
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['cartId'], $data['productId'])) {
            return $this->json(['error' => 'Invalid payload'], 400);
        }

        try {
            $command = new RemoveProductFromCartCommand(
                $data['cartId'],
                new ProductId($data['productId'])
            );

            $handler->__invoke($command);

            return $this->json(['status' => 'Product removed']);
        } catch (\Throwable $e) {
            return $this->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
