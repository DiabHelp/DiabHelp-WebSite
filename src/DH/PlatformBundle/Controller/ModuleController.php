<?php

namespace DH\PlatformBundle\Controller;

use DH\PlatformBundle\Entity\Vote;
use DH\PlatformBundle\Entity\Module;
use DH\PlatformBundle\Entity\CommentModule;
use DH\PlatformBundle\Form\ModuleType;
use DH\PlatformBundle\Form\CommentModuleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ModuleController extends Controller
{
	public function listNameAction()
	{
		$repository = $this->getDoctrine()
				->getManager()
				->getRepository('DHPlatformBundle:Module');

		$modules = $repository->findAll();

		return $this->render('DHPlatformBundle:Module:modulesNameList.html.twig', array('modules' => $modules));
	}

    public function indexAction()
    {
	    $repository = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('DHPlatformBundle:Module');

	    $modules = $repository->findAll();

        return $this->render('DHPlatformBundle:Module:index.html.twig', array('modules' => $modules));
    }

  	public function addAction(Request $request)
  	{
	    $module = new Module();

		$form = $this->get('form.factory')->create(new ModuleType, $module);

	    if ($form->handleRequest($request)->isValid()) {
	    	// $module->setAuthor($this->getUser());
	    	if ($module->getLogo() == "" or $module->getLogo() == null) {
	    		$module->setLogo("basic.jpg");
	    	}
			$em = $this->getDoctrine()->getManager();
			$em->persist($module);
			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Module has been add');

			// On redirige vers la page de visualisation de l'annonce nouvellement créée
			return $this->redirect($this->generateUrl('dh_platform_module'));
	    }

	    return $this->render('DHPlatformBundle:Module:add.html.twig', array(
	      'form' => $form->createView(),
	    ));
  	}

  	public function viewAction(Request $request, $id)
  	{
  		$em = $this->getDoctrine()->getManager();
	    $repository = $em->getRepository('DHPlatformBundle:Module');

	    $module = $repository->find($id);

	    if ($module == null) {
	      throw new NotFoundHttpException("Le module " . $id . " n'existe pas.");
	    }

  		$comment = new CommentModule();

  		$form = $this->get('form.factory')->create(new CommentModuleType, $comment);

	    if ($form->handleRequest($request)->isValid()) {
	    	$comment->setAuthor($this->getUser());
	    	$comment->setModule($module);
	    	$module->addComment($comment);
			$em = $this->getDoctrine()->getManager();
			$em->persist($module, $comment);
			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Comment has been add');

			// On redirige vers la page de visualisation de l'annonce nouvellement créée
			return $this->redirect($this->generateUrl('dh_platform_module_view', array('id' => $module->getId())));
	    }

	    foreach ($module->getComments() as $key => $com) {
	    	$com->setVote($em);
	    }

	    return $this->render('DHPlatformBundle:Module:view.html.twig', array(
	      'module' => $module,
	      'form' => $form->createView(),
	    ));
  	}

  	public function voteAction($id, $note, Request $request)
  	{
  		$em = $this->getDoctrine()->getManager();

  		$vote = $em->getRepository('DHPlatformBundle:Vote')->findBy(array('author' => $this->getUser(),
  																		  'module' => $id,
  																		  ));

  		$module = $em->getRepository('DHPlatformBundle:Module')->find($id);

  		if ($module == null)
  			throw $this->createNotFoundException("Module not found");

  		if ($vote != null)
  			throw $this->createNotFoundException("User has already vote");

  		if ($note == null)
  			throw $this->createNotFoundException("Please precise a note between 1 and 5 as a post param 'vote'");

  		$vote = new Vote();
  		$vote->setVote($note);
  		$vote->setAuthor($this->getUser());
  		$vote->setModule($module);
  		$vote->setDate(new \Datetime());

  		$beforeNote = $module->getNote();
  		$beforeNbVote = $module->getNbVote();
  		$afterNote = (($beforeNote * $beforeNbVote) + $note) / ($beforeNbVote + 1);
  		$module->setNbVote($beforeNbVote + 1);
  		$module->setNote($afterNote);

  		$em->persist($vote);
  		$em->flush();

  		return $this->redirect($this->generateUrl('dh_platform_module_view', array('id' => $module->getId())));
  	}

	public function deleteCommentAction($id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$comment = $em->getRepository('DHPlatformBundle:CommentModule')->find($id);

		if ($comment == null) {
			throw $this->createNotFoundException("Comment ".$id." doesn't exist");
		}
		else if ($comment->getAuthor() != $this->getUser()) {
			throw $this->createNotFoundException("Comment not found for this user");
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

		return $this->redirect($this->generateUrl('dh_platform_module_view', array('id' => $module->getId())));
	}
}
