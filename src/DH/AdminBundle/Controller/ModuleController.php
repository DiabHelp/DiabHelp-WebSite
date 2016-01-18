<?php

namespace DH\AdminBundle\Controller;

use DH\PlatformBundle\Entity\Module;
use DH\PlatformBundle\Entity\CommentModule;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ModuleController extends Controller
{
	public function indexAction(Request $request)
	{
		return $this->render('DHAdminBundle:Module:Module.html.twig');
	}
}
