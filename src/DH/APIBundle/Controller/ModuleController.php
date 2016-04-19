<?php

namespace DH\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ModuleController extends Controller
{

    public function viewAction(Request $request, $id)
    {
		$encoders = new JsonEncoder();
		$normalizer = new ObjectNormalizer();

		$normalizer->setCircularReferenceHandler(function ($object) {
			return $object;
		});

		$this->serializer = new Serializer(array($normalizer), array($encoders));

		$repository = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('DHPlatformBundle:Module');

	    $module = $repository->find($id);

	    if ($module == null) {
	    	throw new NotFoundHttpException("Le module " . $id . " n'existe pas.");
	    }

		foreach ($module->getComments() as $key => $com) {
			$com->getAuthor()->setPassword("");
			$com->getAuthor()->setSalt("");
		}

	    $jsonContent = $this->serializer->serialize($module, 'json');

	    return new Response($jsonContent);
    }

    public function allAction(Request $request)
    {
		$encoders = new JsonEncoder();
		$normalizer = new ObjectNormalizer();

		$normalizer->setCircularReferenceHandler(function ($object) {
			return $object;
		});

		$this->serializer = new Serializer(array($normalizer), array($encoders));

	    $repository = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('DHPlatformBundle:Module');

	    $modules = $repository->findAll();

		foreach ($modules as $key => $module)
			foreach ($module->getComments() as $key => $com) {
				$com->getAuthor()->setPassword("");
				$com->getAuthor()->setSalt("");
			}

		$jsonContent = $this->serializer->serialize($modules, 'json');

	    return new Response($jsonContent);
    	
    }
}
