<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\game;
use AppBundle\Entity\team;
use AppBundle\Entity\User;

class TestControllerController extends Controller
{
  /**
  *@Route("/helloWorld")
  */
  public function helloWorldAction()
  {
      return new Response('<html><body>Hello dupa</body></html>');
  }
  

}
