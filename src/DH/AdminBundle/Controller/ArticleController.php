<?php

namespace DH\AdminBundle\Controller;

use DH\PlatformBundle\Entity\Article;
use DH\PlatformBundle\Entity\CommentArticle;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

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

	public function deleteAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();

		$article = $em->getRepository('DHPlatformBundle:Article')->find($id);

		if ($article) {
			$em->remove($article);
			$em->flush();
			$request->getSession()->getFlashBag()->add('success', 'Article supprimé avec success');
		}
		else {
			$request->getSession()->getFlashBag()->add('info', 'Invalid articleID');
		}
		return $this->redirect($this->generateUrl('dh_admin_articles'));
	}
}
