<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testCreateuser()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/CreateUser');
    }

    public function testDeleteuser()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteUser');
    }

    public function testShowuser()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showUser');
    }

    public function testShowallusers()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showAllUsers');
    }

}
