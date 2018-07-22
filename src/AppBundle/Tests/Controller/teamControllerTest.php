<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class teamControllerTest extends WebTestCase
{
    public function testAddteam()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addTeam');
    }

    public function testShowteam()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showTeam');
    }

    public function testShowallteams()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showAllTeams');
    }

    public function testDeleteteam()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteTeam');
    }

}
