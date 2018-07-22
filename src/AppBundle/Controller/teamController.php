<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\game;
use AppBundle\Entity\team;
use AppBundle\Entity\User;

class teamController extends Controller
{
    /**
     * @Route("/addTeam")
     */
    public function addTeamAction()
    {
        return $this->render('@App/team/add_team.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/showTeam")
     */
    public function showTeamAction()
    {
        return $this->render('AppBundle:team:show_team.html.twig', array(
            // ...
        ));
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
