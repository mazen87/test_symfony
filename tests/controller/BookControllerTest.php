<?php

namespace App\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class BookControllerTest extends WebTestCase
{
    public function testHomeRoute(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    public function testAllBookRoute(): void
    {
        $client = static::createClient();
        $client->request('GET', '/all');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
