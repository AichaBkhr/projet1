<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CartControllerTest extends WebTestCase
{

    public function testAddToCart(): void
    {
        $client = static::createClient();
        
        $client->request('GET', '/cart/add/1');
        $this->assertResponseRedirects('/cart/');
        // Add assertions for the redirection and the updated cart contents
    }

    /*

    public function testRemoveFromCart(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/cart/remove/1');
        $this->assertResponseRedirects('/cart/');
        // Add assertions for the redirection and the updated cart contents
    }

    public function testDeleteFromCart(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/cart/delete/1');
        $this->assertResponseRedirects('/cart/');
        // Add assertions for the redirection and the updated cart contents
    }

    public function testEmptyCart(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/cart/empty');
        $this->assertResponseRedirects('/cart/');
        // Add assertions for the redirection and the empty cart
    }*/
}
