<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UserController extends Controller
{
    /**
     * @Route("/CreateUser")
     */
    public function CreateUserAction()
    {
        return $this->render('AppBundle:User:create_user.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/deleteUser")
     */
    public function deleteUserAction()
    {
        return $this->render('AppBundle:User:delete_user.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/showUser")
     */
    public function showUserAction()
    {
        return $this->render('AppBundle:User:show_user.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/showAllUsers")
     */
    public function showAllUsersAction()
    {
        return $this->render('AppBundle:User:show_all_users.html.twig', array(
            // ...
        ));
    }

}
