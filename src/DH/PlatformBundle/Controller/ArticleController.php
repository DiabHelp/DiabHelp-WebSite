<?php

namespace DH\PlatformBundle\Controller;

use DH\PlatformBundle\Entity\Article;
use DH\PlatformBundle\Entity\CommentArticle;
use DH\PlatformBundle\Form\ArticleType;
use DH\PlatformBundle\Form\CommentArticleType;

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

        return $this->render('DHPlatformBundle:Article:index.html.twig', array('articles' => $articles));
    }

    // ADD ROLE REQUIREMENT
  	public function addAction(Request $request)
  	{
	    $article = new Article();

		$form = $this->get('form.factory')->create(new ArticleType, $article);

	    if ($form->handleRequest($request)->isValid()) {
	    	$article->setAuthor($this->getUser());
			$em = $this->getDoctrine()->getManager();
			$em->persist($article);
			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Article has been add');

			// On redirige vers la page de visualisation de l'annonce nouvellement créée
			return $this->redirect($this->generateUrl('dh_platform_article_view', array('id' => $article->getId())));
	    }

	    return $this->render('DHPlatformBundle:Article:add.html.twig', array(
	      'form' => $form->createView(),
	    ));
  	}

  	// USER POST COMMENTS, NOT ANNONYMOUS
  	public function viewAction(Request $request, $id)
  	{
	    $repository = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('DHPlatformBundle:Article');

	    $article = $repository->find($id);

	    if ($article == null) {
	      throw new NotFoundHttpException("L'article " . $id . " n'existe pas.");
	    }

  		$comment = new CommentArticle();

  		$form = $this->get('form.factory')->create(new CommentArticleType, $comment);

	    if ($form->handleRequest($request)->isValid()) {
	    	$comment->setAuthor($this->getUser());
	    	$comment->setArticle($article);
	    	$article->addComment($comment);
			$em = $this->getDoctrine()->getManager();
			$em->persist($article, $comment);
			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Comment has been add');

			// On redirige vers la page de visualisation de l'annonce nouvellement créée
			return $this->redirect($this->generateUrl('dh_platform_article_view', array('id' => $article->getId())));
	    }

	    return $this->render('DHPlatformBundle:Article:view.html.twig', array(
	      'article' => $article,
	      'form' => $form->createView(),
	    ));
  	}
	
	public function deleteCommentAction($id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$comment = $em->getRepository('DHPlatformBundle:CommentArticle')->find($id);

		if ($comment == null) {
			throw $this->createNotFoundException("Comment ".$id." doesn't exist");
		}
		else if ($comment->getAuthor() != $this->getUser()) {
			throw $this->createNotFoundException("Comment not found for this user");
		}

		$article = $comment->getArticle();

		if ($article == null) {
			throw $this->createNotFoundException("Article not found");
		}

		$allComments = $em->getRepository('DHPlatformBundle:CommentArticle')->findByArticle($article->getId());

		$allow = false;
		
		if (end($allComments) != $comment) {
			throw $this->createNotFoundException("You cannot delete this comment because it's not the last one");
		}

		$em->remove($comment);
		$em->flush();
		$request->getSession()->getFlashBag()->add('info', 'Comment deleted');

		return $this->redirect($this->generateUrl('dh_platform_article_view', array('id' => $article->getId())));
	}

}
