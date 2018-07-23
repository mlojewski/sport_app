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

class UserController extends Controller
{
  /**
   * @Route("/addUser")
   *@Template("@App/User/add_user.html.twig")
   */
  public function addUserAction(Request $request)
  {
      $newUser= new User();
      $newUser->setName($request->request->get('name'));
      $newUser->setLastName($request->request->get('lastName'));
      $newUser->setEmail($request->request->get('email'));
      $newUser->setAdmin(false);
      $newUser->setPassword($request->request->get('password'));
      $em=$this->getDoctrine()->getManager();
      $em->persist($newUser);
      $em->flush();
      return new Response ("added a new user with id ".$newUser->getId());
  }
    /**
     * @Route("/createUser")
     *@Template("@App/User/create_user.html.twig")
     */
    public function CreateUserAction()
    {

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
