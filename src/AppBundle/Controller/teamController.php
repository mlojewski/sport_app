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

class teamController extends Controller
{
    /**
     * @Route("/addTeam")
     *@Template("@App/team/add_team.html.twig")
     */
    public function addTeamAction(Request $request)
    {
    $newTeam = new Team();
    $newTeam->setName($request->request->get('name'));
    $newTeam->setPassword($request->request->get('password'));
    $newTeam->setLogo($request->request->get('logo'));
    $em=$this->getDoctrine()->getManager();
    $em->persist($newTeam);
    $em->flush();
    return new Response ("added new team with id ".$newTeam->getId());
    }
    /**
     * @Route("/createTeam")
     *@Template("@App/team/create_team.html.twig")
     */

public function createTeamAction()
{
  # code...
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

}
