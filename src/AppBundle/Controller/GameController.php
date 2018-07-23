<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GameController extends Controller
{
    /**
     * @Route("/createGame")
     */
    public function createGameAction()
    {
        return $this->render('AppBundle:Game:create_game.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/addGame")
     */
    public function addGameAction()
    {
        return $this->render('AppBundle:Game:add_game.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/showGame")
     */
    public function showGameAction()
    {
        return $this->render('AppBundle:Game:show_game.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/showAllGames")
     */
    public function showAllGamesAction()
    {
        return $this->render('AppBundle:Game:show_all_games.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/deleteGame")
     */
    public function deleteGameAction()
    {
        return $this->render('AppBundle:Game:delete_game.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/showTeamGames")
     */
    public function showTeamGamesAction()
    {
        return $this->render('AppBundle:Game:show_team_games.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/modifyGame")
     */
    public function modifyGameAction()
    {
        return $this->render('AppBundle:Game:modify_game.html.twig', array(
            // ...
        ));
    }

}
