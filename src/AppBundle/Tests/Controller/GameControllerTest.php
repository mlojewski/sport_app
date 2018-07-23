<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameControllerTest extends WebTestCase
{
    public function testCreategame()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createGame');
    }

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

    public function testShowallgames()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showAllGames');
    }

    public function testDeletegame()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteGame');
    }

    public function testShowteamgames()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showTeamGames');
    }

    public function testModifygame()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/modifyGame');
    }

}
