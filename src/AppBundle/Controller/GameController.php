<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Game;
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
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function createGameAction(Request $request)
    {
      $gametest = new Game();
      $form=$this->createFormBuilder($gametest)->add('homeTeam', EntityType::class, array('class'=>'AppBundle:team', 'choice_label'=>'name'))
      ->add('awayTeam', EntityType::class, array('class'=>'AppBundle:team', 'choice_label'=>'name'))
      ->add('scoreHome', IntegerType::class, array('attr'=>array('min'=>0)))->add('scoreAway', IntegerType::class, array('attr'=>array('min'=>0)))->add('date', DateTimeType::class)
      ->add('result', ChoiceType::class,(array('choices'=>array('not played' => null, 'home win' =>1, 'draw' => 0, 'away win'=>2),'choice_attr' => function($choiceValue, $key, $value) {
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
        $homeTeam = $gameTest->getHomeTeam();
        $awayTeam=$gameTest->getAwayTeam();
        $gameTest->addTeamGames($homeTeam);
          $gameTest->addTeamGames($awayTeam);
        $em->persist($gameTest);
        $em->flush();

        return $this->redirectToRoute('addGame');
      }
      return $this->render('@App/Game/create_game.html.twig', array('form'=>$form->createView()));
    }

    /**
     * @Route("/addGame", name="addGame")
     */
    public function addGameAction()
    {
      $em=$this->getDoctrine()->getManager();
      $query=$em->createQuery('SELECT game FROM AppBundle:Game game ORDER BY game.id DESC');
      $newGame=$query->setMaxResults(1)->getOneOrNullResult();
    return $this->render('@App/Game/add_game.html.twig', array('newGame'=>$newGame));
    }

    /**
     * @Route("/showGame/{id}")
     */
    public function showGameAction($id)
    {
        $repository=$this->getDoctrine()->getRepository('AppBundle:Game');
        $game=$repository->find($id);
        return $this->render('@App/Game/show_game.html.twig', array('game'=>$game));
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
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteGameAction($id)
    {
      $repository=$this->getDoctrine()->getRepository('AppBundle:Game');
      $gameToDelete=$repository->find($id);
        $homeTeam=$this->getDoctrine()->getRepository('AppBundle:team')->findOneByName($gameToDelete->getHomeTeam()); //samo findby zwraca tablicę a findoneby obiekt
        $awayTeam=$this->getDoctrine()->getRepository('AppBundle:team')->findOneByName($gameToDelete->getAwayTeam());
      $em=$this->getDoctrine()->getManager();
      $homeScore=$gameToDelete->getScoreHome();
      $awayScore=$gameToDelete->getScoreAway();

      if ($gameToDelete) {
          if ($gameToDelete->getResult()==1){
              $homeTeam->setPointsFor($homeTeam->getPointsFor() - 3);
          }elseif ($gameToDelete->getResult() == 0){
              $homeTeam->setPointsFor($homeTeam->getPointsFor()-1);
              $awayTeam->setPointsFor($awayTeam->getPointsFor()-1);
          }elseif($gameToDelete->getResult()== 2){
              $awayTeam->setPointsFor($awayTeam->getPointsFor() - 3);
          }
          $homeTeam->setScoresFor($homeTeam->getScoresFor()-$homeScore);
          $homeTeam->setScoresAgainst($homeTeam->getScoresAgainst() - $awayScore);
          $awayTeam->setScoresFor($awayTeam->getScoresFor()-$awayScore);
          $awayTeam->setScoresAgainst($awayTeam->getScoresAgainst() - $homeScore);
        $em->remove($gameToDelete);
        $em->flush();
        return $this->render('@App/Game/delete_game.html.twig', array('gameToDelete'=>$gameToDelete));
      }
      return new Response ('<a href="/">wróć do głównej</a><br>nie ma takiego meczu');
    }


    /**
     * @Route("/modifyGame/{id}")
     *@Security("is_granted('ROLE_ADMIN')")
     */
    public function modifyGameAction($id, Request $request)
    {
      $gameToUpdate=$this->getDoctrine()->getRepository('AppBundle:Game')->find($id);

      $homeTeam=$this->getDoctrine()->getRepository('AppBundle:team')->findOneByName($gameToUpdate->getHomeTeam()); //samo findby zwraca tablicę a findoneby obiekt
      $awayTeam=$this->getDoctrine()->getRepository('AppBundle:team')->findOneByName($gameToUpdate->getAwayTeam());

      if (!$gameToUpdate) {
        return new Response ("nie ma meczu o id ".$id);
      }
      $gameToUpdate->setHomeTeam($gameToUpdate->getHomeTeam());
      $gameToUpdate->setAwayTeam($gameToUpdate->getAwayTeam());
      $baseScoreHome=$gameToUpdate->getScoreHome();
      $gameToUpdate->setScoreHome($baseScoreHome);
      $baseScoreAway=$gameToUpdate->getScoreAway();
      $gameToUpdate->setScoreAway($baseScoreAway);
      $baseResult=$gameToUpdate->getResult();
      $gameToUpdate->setResult($baseResult);
      $gameToUpdate->setDate($gameToUpdate->getDate());
      $gameToUpdate->setDescription($gameToUpdate->getDescription());
      $form=$this->createFormBuilder($gameToUpdate)
      ->add('scoreHome', IntegerType::class, array('attr'=>array('min'=>0)))->add('scoreAway', IntegerType::class, array('attr'=>array('min'=>0)))->add('date', DateTimeType::class)
      ->add('result', ChoiceType::class,(array('choices'=>array('home win' =>1, 'draw' => 0, 'away win'=>2),'choice_attr' => function($choiceValue, $key, $value) {
      return ['class' => 'attending_'.strtolower($key)];},)))
      ->add('description', TextType::class, array('attr'=>array('maxlength'=>1990)))
      ->add('save', SubmitType::class, array('attr' => array('class' => 'update'),))
      ->getForm();
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {


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

        if ($baseResult != $result) {
            if ($result == 1) {
                $homeTeam->setPointsFor($homeTeam->getPointsFor() + 3);
            } elseif ($result == 0) {
                $homeTeam->setPointsFor($homeTeam->getPointsFor() + 1);
                $awayTeam->setPointsFor($awayTeam->getPointsFor() + 1);
            } elseif ($result == 2) {
                $awayTeam->setPointsFor($awayTeam->getPointsFor() + 3);
            }
        }
        if ($baseScoreHome != $scoreHome){
            $homeTeam->setScoresFor($homeTeam->getScoresFor() + $scoreHome - $baseScoreHome);
            $homeTeam->setScoresAgainst($homeTeam->getScoresAgainst() + $scoreAway - $baseScoreAway);
        }
          if ($baseScoreAway != $scoreAway){
              $awayTeam->setScoresFor($awayTeam->getScoresFor() + $scoreAway - $baseScoreAway);
              $awayTeam->setScoresAgainst($awayTeam->getScoresAgainst() + $scoreHome - $baseScoreHome);
          }

        $em->flush();
        return $this->redirectToRoute('show_all_games');
      }

      return $this->render('@App/Game/modify_game.html.twig', array('form'=>$form->createView(), 'game'=>$gameToUpdate));
    }



}
