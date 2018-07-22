<?php

namespace AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
  public function helloWorld()
  {
    echo "hello world";
  }
}
