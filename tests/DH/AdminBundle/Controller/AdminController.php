<?php

namespace DH\AdminBundle\Controller;

// use DH\PlatformBundle\Entity\Vote;
// use DH\PlatformBundle\Entity\Module;
// use DH\PlatformBundle\Entity\CommentModule;
// use DH\PlatformBundle\Entity\Article;
// use DH\PlatformBundle\Entity\CommentArticle;

// use DH\PlatformBundle\Form\ArticleType;
// use DH\PlatformBundle\Form\CommentArticleType;
// use DH\PlatformBundle\Form\ModuleType;
// use DH\PlatformBundle\Form\CommentModuleType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
	public function indexAction(Request $request)
	{
		return $this->render('DHAdminBundle:Admin:index.html.twig');
	}
}
