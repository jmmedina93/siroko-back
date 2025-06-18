<?php

namespace App\Tests\Functional\OrderContext;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProcessOrderTest extends WebTestCase
{
    public function test_checkout_creates_order_from_cart(): void
    {
        $client = static::createClient();

        // Paso 1: Añadir producto (genera carrito)
        $client->request('POST', '/api/cart/add', [], [], [
            'CONTENT_TYPE' => 'application/json'
        ], json_encode([
            'productId' => 'checkout-product-1',
            'quantity' => 1
        ]));

        $this->assertResponseIsSuccessful();

        $response = json_decode($client->getResponse()->getContent(), true);
        $cartId = $response['cartId'];

        // Paso 2: Procesar la orden
        $client->request('POST', '/api/order/checkout', [], [], [
            'CONTENT_TYPE' => 'application/json'
        ], json_encode([
            'cartId' => $cartId
        ]));

        $this->assertResponseIsSuccessful();

        $orderResponse = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('orderId', $orderResponse);
        $this->assertIsString($orderResponse['orderId']);
    }
}
