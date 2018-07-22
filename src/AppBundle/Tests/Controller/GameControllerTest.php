<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameControllerTest extends WebTestCase
{
    public function testAddgame()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addGame');
    }

    public function testShowgame()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showGame');
    }

    public function testDeletegame()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteGame');
    }

}
