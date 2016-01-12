<?php

namespace DH\AdminBundle\Controller;

use DH\PlatformBundle\Entity\Article;
use DH\PlatformBundle\Entity\CommentArticle;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{
	public function indexAction(Request $request)
	{
	    $repository = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('DHPlatformBundle:Article');

	    $articles = $repository->findAll();

        return $this->render('DHAdminBundle:Article:index.html.twig', array('articles' => $articles));
	}
}
