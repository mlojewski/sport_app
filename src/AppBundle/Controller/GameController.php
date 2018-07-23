<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\game;
use AppBundle\Entity\team;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class GameController extends Controller
{
    /**
     * @Route("/createGame")
     *@Template("@App/Game/create_game.html.twig")
     */
    public function createGameAction()
    {

    }

    /**
     * @Route("/addGame")
        *@Template("@App/Game/add_game.html.twig")
     */
    public function addGameAction(Request $request)
    {
      $repositoryTeam=$this->getDoctrine()->getRepository('AppBundle:team');
      $allTeams=$repositoryTeam->findAll();
      $em=$this->getDoctrine()->getManager();
      if (count($request->request)!=0) {
        $newGame= new Game();
        $homeTeam=$repositoryTeam->find($request->request->get('homeTeam'));
        $newGame->setHomeTeam($homeTeam);
        $awayTeam=$repositoryTeam->find($request->request->get('awayTeam'));
        $newGame->setAwayTeam($awayTeam);
        $newGame->setScoreHome($request->request->get('scoreHome'));
        $newGame->setScoreAway($request->request->get('scoreAway'));
        $newGame->setResult($request->request->get('result'));
        //rezultat meczu to 1 wygrana gospodarzy 0 remis 2 wygrana gości
        $newGame->setDate($request->request->get('date'));
        $newGame->setDescription($request->request->get('description'));
        $em->persist($newGame);
        $em->flush();

      }
      return ['allTeams'=>$allTeams];
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
