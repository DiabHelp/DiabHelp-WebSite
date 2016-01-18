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
}
