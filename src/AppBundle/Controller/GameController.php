<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class GameController extends Controller
{
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
     * @Route("/deleteGame")
     */
    public function deleteGameAction()
    {
        return $this->render('AppBundle:Game:delete_game.html.twig', array(
            // ...
        ));
    }

}
