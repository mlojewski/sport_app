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

class UserController extends Controller
{
  /**
   * @Route("/addUser", name="addUser")
   *@Template("@App/User/add_user.html.twig")
   */
  public function addUserAction(Request $request)
  {
      // $newUser= new User();
      // $newUser->setName($request->request->get('name'));
      // $newUser->setLastName($request->request->get('lastName'));
      // $newUser->setEmail($request->request->get('email'));
      // $newUser->setAdmin(false);
      // $newUser->setPassword($request->request->get('password'));
      // $em=$this->getDoctrine()->getManager();
      // $em->persist($newUser);
      // $em->flush();
      // return new Response ("added a new user with id ".$newUser->getId());
      // TODO: ściągnięcie ostatniego rekordu z bazy i wypisanie go
  }
    /**
     * @Route("/createUser")
     *@Template("@App/User/create_user.html.twig")
     */
    public function CreateUserAction(Request $request)
    {
      $newUser = new User();
      $form=$this->createFormBuilder($newUser)->add('name', TextType::class)
      ->add('lastName', TextType::class) ->add('email', EmailType::class)->add('password', PasswordType::class)
      ->add('send', SubmitType::class, array('label' => 'Create User'))->getForm();
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $newUser=$form->getData();
        $newUser->setAdmin(false);
        $em=$this->getDoctrine()->getManager();
        $em->persist($newUser);
        $em->flush();
        return $this->redirectToRoute('addUser');
      }
      return $this->render('@App/User/create_user.html.twig', array('form'=>$form->createView(),));
    }

    /**
     * @Route("/deleteUser/{id}")
     *@Template("@App/User/delete_user.html.twig")
     */
    public function deleteUserAction()
    {
        $repository=$this->getDoctrine()->getRepository('AppBundle:User');
        $userToDelete=$repository->findId($id);
        $em=$this->getDoctrine()->getManager();
        if ($userToDelete) {
          $em->remove($userToDelete);
          $em->flush();
          return new Response("usunięto użytkownika o id: $id");
        }
        return new Response("nie ma takiego użytkownika");
    }

    /**
     * @Route("/showUser/{id}")
     *@Template("@App/User/show_user.html.twig")
     */
    public function showUserAction($id)
    {
        $repository=$this->getDoctrine()->getRepository('AppBundle:User');
        $user=$repository->find($id);
        return new Response('wczytany użytkownik to: '.$user->getName().' '.$user->getLastName());

    }

    /**
     * @Route("/showAllUsers")
     *@Template("@App/User/show_all_users.html.twig")
     */
    public function showAllUsersAction()
    {
        $repository=$this->getDoctrine()->getRepository('AppBundle:User');
        $allUsers=$repository->findAll();
        return['allUsers'=>$allUsers];
    }

}
