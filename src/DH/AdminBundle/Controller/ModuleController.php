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
	    $repository = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('DHPlatformBundle:Module');

	    $modules = $repository->findAll();

        return $this->render('DHAdminBundle:Module:index.html.twig', array('modules' => $modules));
	}

	public function deleteAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();

		$module = $em->getRepository('DHPlatformBundle:Module')->find($id);

		if ($module) {
			$em->remove($module);
			$em->flush();
			$request->getSession()->getFlashBag()->add('success', 'Module supprimé avec success');
		}
		else {
			$request->getSession()->getFlashBag()->add('error', 'Id module invalide');
		}
		return $this->redirect($this->generateUrl('dh_admin_modules'));
	}

  	public function viewAction(Request $request, $id)
  	{
  		$em = $this->getDoctrine()->getManager();
	    $repository = $em->getRepository('DHPlatformBundle:Module');

	    $module = $repository->find($id);

	    if ($module == null) {
	      throw new NotFoundHttpException("Le module " . $id . " n'existe pas.");
	    }

  		// $comment = new CommentModule();

  		// $form = $this->get('form.factory')->create(new CommentModuleType, $comment);

	    // if ($form->handleRequest($request)->isValid()) {
	    	// $comment->setAuthor($this->getUser());
	    	// $comment->setModule($module);
	    	// $module->addComment($comment);
			// $em = $this->getDoctrine()->getManager();
			// $em->persist($module, $comment);
			// $em->flush();

			// $request->getSession()->getFlashBag()->add('notice', 'Comment has been add');

			// // On redirige vers la page de visualisation de l'annonce nouvellement créée
	    // }
	    foreach ($module->getComments() as $key => $com) {
	    	$com->setVote($em);
	    }

	    return $this->render('DHAdminBundle:Module:view.html.twig', array(
	      'module' => $module,
	    ));
  	}

	public function deleteCommentAction($id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$comment = $em->getRepository('DHPlatformBundle:CommentModule')->find($id);

		if ($comment == null) {
			throw $this->createNotFoundException("Comment ".$id." doesn't exist");
		}

		$module = $comment->getModule();

		if ($module == null) {
			throw $this->createNotFoundException("Module not found");
		}

		$allComments = $em->getRepository('DHPlatformBundle:CommentModule')->findByModule($module->getId());

		$allow = false;
		
		if (end($allComments) != $comment) {
			throw $this->createNotFoundException("You cannot delete this comment because it's not the last one");
		}

		$em->remove($comment);
		$em->flush();
		$request->getSession()->getFlashBag()->add('info', 'Comment deleted');

		return $this->redirect($this->generateUrl('dh_admin_modules_view', array('id' => $module->getId())));
	}
}
