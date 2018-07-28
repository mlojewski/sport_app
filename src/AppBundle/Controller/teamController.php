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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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

    }
    /**
     * @Route("/createTeam")
     *@Template("@App/team/create_team.html.twig")
     */

public function createTeamAction(Request $request)
{
    $newTeam = new Team();
    $form=$this->createFormBuilder($newTeam)->add('name', TextType::class)->add('password', PasswordType::class)
    ->add('logo', TextType::class)->add('send', SubmitType::class, array('label' =>'Create Team'))->getForm();
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $newTeam=$form->getData();
      $em=$this->getDoctrine()->getManager();
      $em->persist($newTeam);
      $em->flush();
      return $this->redirectToRoute('addTeam');
}
return $this->render('@App/team/create_team.html.twig', array('form'=>$form->createView(),));
}
    /**
     * @Route("/showTeam/{id}")
     *@Template("@App/team/show_team.html.twig")
     */
    public function showTeamAction($id)
    {
    $repository=$this->getDoctrine()->getRepository('AppBundle:team');
    $team=$repository->find($id);
    return new Response('wczytana drużyna to '.$team->getName());
    }

    /**
     * @Route("/showAllTeams")
     *@Template("@App/team/show_all_teams.html.twig")
     */
    public function showAllTeamsAction()
    {
        $repository=$this->getDoctrine()->getRepository('AppBundle:team');
        $allTeams=$repository->findAll();
        return['allTeams'=>$allTeams];
    }

    /**
     * @Route("/deleteTeam/{id}")
     *@Template("@App/team/delete_team.html.twig")
     */
    public function deleteTeamAction($id)
    {
        $repository=$this->getDoctrine()->getRepository('AppBundle:team');
        $teamToDelete=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        if ($teamToDelete) {
          $em->remove($teamToDelete);
          $em->flush();
          return new Response ("usunięto drużynę o id = $id");
        }
        return new Response ("nie ma takiej drużyny");
    }
    /**
     * @Route("/updateTeam/{id}")
     *@Template("@App/team/update_team.html.twig")
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
