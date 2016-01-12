<?php

namespace DH\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DiabhelpController extends Controller
{
    public function indexAction()
    {
        return $this->render('DHPlatformBundle:Diabhelp:index.html.twig');
    }

    public function legalAction()
    {
        return $this->render('DHPlatformBundle:Diabhelp:legal.html.twig');
    }

    public function contactAction()
    {
        return $this->render('DHPlatformBundle:Diabhelp:contact.html.twig');
    }

    public function profileAction()
    {
        return $this->render('DHPlatformBundle:Diabhelp:profile.html.twig');
    }

    public function forgetPwdAction()
    {
        return $this->render('DHPlatformBundle:Diabhelp:forgetPwd.html.twig');
    }
}
