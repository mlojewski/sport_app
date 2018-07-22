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
     * @Route("/addGame")
     *@Template("@App/Game/add_game.html.twig")
     */
    public function addGameAction(Request $request)
    {
      $repositoryTeam = $this->getDoctrine()->getRepository('AppBundle:team');
      $teams=$repositoryTeam->findAll();

      $em=$this->getDoctrine()->getManager();
      if (count($request->request)!=0) {
        $newGame=new Game();
        // $homeTeam=$repositoryTeam->find($request->request->get('homeTeam'));
        // $newGame->setHome($homeTeam);
        // $awayTeam=$repositoryTeam->find($request->request->get('awayTeam'));
        // $newGame->setAway($awayTeam);
        $newGame->setHome("teamA");
        $newGame->setAway("teamB");
        $newGame->setScoreHome(0);
        $newGame->setScoreAway(0);
        $newGame->setResult(0);
        $newGame->setHour(0);
        $newGame->setDescription('blank');
        $newGame->setDate("232332");
        $em->persist($newGame);
        $em->flush();
        return new Response ("added new game with id ".$newGame->getId());
      }
    }

    /**
     * @Route("/createGame")
     *@Template("@App/Game/create_game.html.twig")
     */
    public function createGameAction()
    {

    }
    /**
     * @Route("/showGame/{id}")
     *@Template("@App/Game/show_game.html.twig")
     */
    public function showGameAction()
    {
        $repository=$this->getDoctrine()->getRepository('AppBundle:game');
        $gameId=$repository->find($id);

        // TODO: skończyć!
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
// TODO: dodać akcję i twigi wgrywania meczów danej drużyny oraz modyfikowanie opisu meczu
}
