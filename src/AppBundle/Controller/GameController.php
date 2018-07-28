<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Game;
use AppBundle\Entity\team;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class GameController extends Controller
{
    /**
     * @Route("/createGame")
     *@Template("@App/Game/create_game.html.twig")
     */
    public function createGameAction(Request $request)
    {
      $gametest = new Game();
      $form=$this->createFormBuilder($gametest)->add('homeTeam', EntityType::class, array('class'=>'AppBundle:team', 'choice_label'=>'name'))
      ->add('awayTeam', EntityType::class, array('class'=>'AppBundle:team', 'choice_label'=>'name'))
      ->add('scoreHome', IntegerType::class, array('attr'=>array('min'=>0)))->add('scoreAway', IntegerType::class, array('attr'=>array('min'=>0)))->add('date', DateTimeType::class)
      ->add('result', ChoiceType::class,(array('choices'=>array('home win' =>1, 'draw' => 0, 'away win'=>2),'choice_attr' => function($choiceValue, $key, $value) {
      // adds a class like attending_yes, attending_no, etc
      return ['class' => 'attending_'.strtolower($key)];
    },)))
      ->add('description', TextType::class, array('attr'=>array('maxlength'=>1990)))
      ->add('save', SubmitType::class, array('attr' => array('class' => 'save'),))
      ->getForm();
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $gameTest=$form->getData();
        $em=$this->getDoctrine()->getManager();
        $em->persist($gameTest);
        $em->flush();
        return $this->redirectToRoute('addGame');
      }
      return $this->render('@App/Game/show_team_games.html.twig', array('form'=>$form->createView()));
    }

    /**
     * @Route("/addGame", name="addGame")
        *@Template("@App/Game/add_game.html.twig")
     */
    public function addGameAction()
    {
      $em=$this->getDoctrine()->getManager();
      $query=$em->createQuery('SELECT game FROM AppBundle:Game game ORDER BY game.id DESC');
      $newGame=$query->setMaxResults(1)->getOneOrNullResult();
    return new Response ('utworzono mecz o id '.$newGame->getId());
    }

    /**
     * @Route("/showGame/{id}")
     *@Template("@App/Game/show_game.html.twig")
     */
    public function showGameAction($id)
    {
        $repository=$this->getDoctrine()->getRepository('AppBundle:Game');
        $game=$repository->find($id);
        return new Response ('wczytany mecz to '.$game->getHomeTeam()." - ".$game->getAwayTeam()." zakończony wynikiem ".$game->getScoreHome()." : ".$game->getScoreAway());
    }

    /**
     * @Route("/showAllGames", name="show_all_games")
     *@Template("@App/Game/show_all_games.html.twig")
     */
    public function showAllGamesAction()
    {
        $repository=$this->getDoctrine()->getRepository('AppBundle:Game');
        $allGames=$repository->findAll();
        return['allGames'=>$allGames];

    }

    /**
     * @Route("/deleteGame/{id}")
     *@Template("@App/Game/delete_game.html.twig")
     */
    public function deleteGameAction($id)
    {
      $repository=$this->getDoctrine()->getRepository('AppBundle:Game');
      $gameToDelete=$repository->find($id);
      $em=$this->getDoctrine()->getManager();
      if ($teamToDelete) {
        $em->remove($teamToDelete);
        $em->flush();
        return new Response ("usunięto mecz o id = $id");
      }
      return new Response ("nie ma takiego meczu");
    }

    /**
     * @Route("/showTeamGames/{name}")
     *@Template("@App/Game/show_team_games.html.twig")
     */
    public function showTeamGamesAction($name)
    {

        $repository=$this->getDoctrine()->getRepository('AppBundle:Game');
        $homeGames = $repository->findByHomeTeam($name);
        $awayGames=$repository->findByAwayTeam($name);
        $allTeamGames=array_merge($homeGames, $awayGames);

        return ['allTeamGames'=>$allTeamGames];
    }
    /**
     * @Route("/modifyGame/{id}")
     *@Template("@App/Game/modify_game.html.twig")
     */
    public function modifyGameAction($id, Request $request)
    {
      $gameToUpdate=$this->getDoctrine()->getRepository('AppBundle:Game')->find($id);
      if (!$gameToUpdate) {
        return new Response ("nie ma meczu o id ".$id);
      }
      $gameToUpdate->setHomeTeam($gameToUpdate->getHomeTeam());
      $gameToUpdate->setAwayTeam($gameToUpdate->getAwayTeam());
      $gameToUpdate->setScoreHome($gameToUpdate->getScoreHome());
      $gameToUpdate->setScoreAway($gameToUpdate->getScoreAway());
      $gameToUpdate->setResult($gameToUpdate->getResult());
      $gameToUpdate->setDate($gameToUpdate->getDate());
      $gameToUpdate->setDescription($gameToUpdate->getDescription());
      $form=$this->createFormBuilder($gameToUpdate)->add('homeTeam', EntityType::class, array('class'=>'AppBundle:team', 'choice_label'=>'name'))
      ->add('awayTeam', EntityType::class, array('class'=>'AppBundle:team', 'choice_label'=>'name'))
      ->add('scoreHome', IntegerType::class, array('attr'=>array('min'=>0)))->add('scoreAway', IntegerType::class, array('attr'=>array('min'=>0)))->add('date', DateTimeType::class)
      ->add('result', ChoiceType::class,(array('choices'=>array('home win' =>1, 'draw' => 0, 'away win'=>2),'choice_attr' => function($choiceValue, $key, $value) {
      return ['class' => 'attending_'.strtolower($key)];},)))
      ->add('description', TextType::class, array('attr'=>array('maxlength'=>1990)))
      ->add('save', SubmitType::class, array('attr' => array('class' => 'update'),))
      ->getForm();
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {

        $homeTeam=$form['homeTeam']->getData();
        $awayTeam=$form['awayTeam']->getData();
        $scoreHome=$form['scoreHome']->getData();
        $scoreAway=$form['scoreAway']->getData();
        $result=$form['result']->getData();
        $date=$form['date']->getData();
        $description=$form['description']->getData();
        $em=$this->getDoctrine()->getManager();
        $gameToUpdate =$em->getRepository('AppBundle:Game')->find($id);
        $gameToUpdate->setHomeTeam($homeTeam);
        $gameToUpdate->setAwayTeam($awayTeam);
        $gameToUpdate->setScoreHome($scoreHome);
        $gameToUpdate->setScoreAway($scoreAway);
        $gameToUpdate->setResult($result);
        $gameToUpdate->setDate($date);
        $gameToUpdate->setDescription($description);
        $em->flush();
        return $this->redirectToRoute('show_all_games');
      }
      return $this->render('@App/Game/modify_game.html.twig', array('form'=>$form->createView(),));;
    }



}
