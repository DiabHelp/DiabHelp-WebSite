<?php

namespace DH\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DHUserBundle extends Bundle
{
  public function getParent()
  {
    return 'FOSUserBundle';
  }
}
