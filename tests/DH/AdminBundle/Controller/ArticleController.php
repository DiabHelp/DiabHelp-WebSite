<?php

namespace DH\AdminBundle\Controller;

use DH\PlatformBundle\Entity\Article;

use DH\PlatformBundle\Form\ArticleType;
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

    public function addAction(Request $request)
    {
        $article = new Article();

        $form = $this->get('form.factory')->create(new ArticleType, $article);

        if ($form->handleRequest($request)->isValid()) {
            if ($article->getImageName() == "" or $article->getImageName() == null) {
                $article->setImageName("av-def.jpg");
                $article->setUpdatedAtNow();
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Article has been add');

            return $this->redirect($this->generateUrl('dh_admin_articles'));
        }

        return $this->render('DHAdminBundle:Article:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('DHPlatformBundle:Article')->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No article found for id ' . $id
            );
        }

        $form = $this->get('form.factory')->create(new ArticleType, $user);

        if ($form->handleRequest($request)->isValid()) {

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Article has been modified');

            return $this->redirect($this->generateUrl('dh_admin_articles'));
        }

        return $this->render('DHAdminBundle:Article:add.html.twig', array(
            'form' => $form->createView(),
        ));
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

    public function hideOrShowAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('DHPlatformBundle:Article')->find($id);

        if ($article) {
            if ($article->getDisplay() == 0)
                $article->setDisplay(1);
            else
                $article->setDisplay(0);
            $em->persist($article);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'article édité avec success');
        }
        else {
            $request->getSession()->getFlashBag()->add('error', 'Id article invalide');
        }
        return $this->redirect($this->generateUrl('dh_admin_articles'));
    }
}
