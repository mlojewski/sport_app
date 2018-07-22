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
$newTeam->setName('team testowy');
$newTeam->setPassword("aaa");
$newTeam->setLogo("ofofof");
$em=$this->getDoctrine()->getManager();
$em->persist($newTeam);
$em->flush();
return new Response ("created new team with id ".$newTeam->getId());
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
     */
    public function showAllTeamsAction()
    {
        return $this->render('AppBundle:team:show_all_teams.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/deleteTeam")
     */
    public function deleteTeamAction()
    {
        return $this->render('AppBundle:team:delete_team.html.twig', array(
            // ...
        ));
    }

}
