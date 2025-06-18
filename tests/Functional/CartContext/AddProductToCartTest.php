<?php

namespace App\Tests\Functional\CartContext;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddProductToCartTest extends WebTestCase
{
    public function test_add_product_returns_cart_id_and_items(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/cart/add', [], [], [
            'CONTENT_TYPE' => 'application/json'
        ], json_encode([
            'productId' => 'test-product-1',
            'quantity' => 2
        ]));

        $this->assertResponseIsSuccessful();

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('cartId', $response);
        $this->assertIsString($response['cartId']);
        $this->assertCount(1, $response['items']);
        $this->assertSame('test-product-1', $response['items'][0]['productId']);
        $this->assertSame(2, $response['items'][0]['quantity']);
    }
}
