<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\team;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class teamController extends Controller
{
    /**
     * @Route("/addTeam", name="addTeam")
     *@Template("@App/team/add_team.html.twig")
     */
    public function addTeamAction()
    {
      $em=$this->getDoctrine()->getManager();
      $query=$em->createQuery('SELECT team FROM AppBundle:team team ORDER BY team.id DESC');
      $newTeam=$query->setMaxResults(1)->getOneOrNullResult();
      return $this->render('@App/team/add_team.html.twig', array('newTeam'=>$newTeam));

    }
    /**
     * @Route("/createTeam")
    * @Security("is_granted('ROLE_ADMIN')")
     */

public function createTeamAction(Request $request)
{
    $newTeam = new Team();
    $form=$this->createFormBuilder($newTeam)->add('name', TextType::class)->add('password', PasswordType::class)
    ->add('logo', TextType::class)->add('send', SubmitType::class, array('label' =>'Create Team'))->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $newTeam=$form->getData();
      $newTeam->setPointsFor(0);
      $newTeam->setScoresFor(0);
      $newTeam->setScoresAgainst(0);

      $em=$this->getDoctrine()->getManager();
      $em->persist($newTeam);
      $em->flush();
      return $this->redirectToRoute('addTeam');
}
return $this->render('@App/team/create_team.html.twig', array('form'=>$form->createView()));
}
    /**
     * @Route("/showTeam/{id}")
     */
    public function showTeamAction($id)
    {
    $repository=$this->getDoctrine()->getRepository('AppBundle:team');
    $team=$repository->find($id);

    return $this->render('@App/team/show_team.html.twig', array('team'=>$team));
    }

    /**
     * @Route("/showAllTeams")
     */
    public function showAllTeamsAction()
    {
        $repository=$this->getDoctrine()->getRepository('AppBundle:team');
        $allTeams=$repository->findAll();
        return $this->render('@App/team/show_all_teams.html.twig', array('allTeams'=>$allTeams));
    }

    /**
     * @Route("/showTeamGames/{name}")
     *@Template("@App/team/show_team_games.html.twig")
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
     * @Route("/showTable")
     */
    public function showTableAction()
    {

        $em=$this->getDoctrine()->getManager();
        $query=$em->createQuery('SELECT team FROM AppBundle:team team ORDER BY team.pointsFor DESC');
        $table=$query->getResult();

        return  $this->render('@App/team/show_table.html.twig', array('allTeams'=>$table));
    }

    /**
     * @Route("/deleteTeam/{id}")
     *@Template("@App/team/delete_team.html.twig")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function deleteTeamAction($id)
    {
        $repository=$this->getDoctrine()->getRepository('AppBundle:team');
        $teamToDelete=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        if ($teamToDelete) {
          $em->remove($teamToDelete);
          $em->flush();

          return $this->render('@App/team/delete_team.html.twig', array('teamToDelete'=>$teamToDelete));
        }
        return new Response ("nie ma takiej drużyny");
    }
    /**
     * @Route("/updateTeam/{id}")
     *@Template("@App/team/update_team.html.twig")
     * @Security("is_granted('ROLE_ADMIN')")
     */

    public function updateTeamAction(Request $request, $id)
    {
      $teamToUpdate=$this->getDoctrine()->getRepository('AppBundle:team')->find($id);
      $teamToUpdate->setName($teamToUpdate->getname());
      $teamToUpdate->setPassword($teamToUpdate->getPassword());
      $teamToUpdate->setLogo($teamToUpdate->getLogo());

      $form=$this->createFormBuilder($teamToUpdate)->add('name', TextType::class)->add('password', PasswordType::class)
      ->add('logo', TextType::class)->add('send', SubmitType::class, array('label' =>'Update Team'))->getForm();
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $name=$form['name']->getData();
        $password=$form['password']->getData();
        $logo=$form['logo']->getData();
        $em=$this->getDoctrine()->getManager();
        $teamToUpdate =$em->getRepository('AppBundle:team')->find($id); // celem wyszukania id drużyny do aktualizacji
        $teamToUpdate->setName($name);
        $teamToUpdate->setPassword($password);
        $teamToUpdate->setLogo($logo);
        $em->flush();
      }
      return $this->render('@App/team/update_team.html.twig', array('form'=>$form->createView(),));
    }

}
