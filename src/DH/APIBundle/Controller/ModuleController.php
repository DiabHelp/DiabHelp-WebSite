<?php

namespace DH\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use DH\PlatformBundle\Entity\Module;

class ModuleController extends Controller
{

    public function viewAction(Request $request, $id)
    {
    	$encoders = array(new XmlEncoder(), new JsonEncoder());
		$normalizers = array(new ObjectNormalizer());

		$this->serializer = new Serializer($normalizers, $encoders);

	    $repository = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('DHPlatformBundle:Module');

	    $module = $repository->find($id);

	    if ($module == null) {
	    	throw new NotFoundHttpException("Le module " . $id . " n'existe pas.");
	    }

	    $jsonContent = $this->serializer->serialize($module, 'json');

	    return new Response($jsonContent);
    }

    public function allAction(Request $request)
    {
    	$encoders = array(new XmlEncoder(), new JsonEncoder());
		$normalizers = array(new ObjectNormalizer());

		$this->serializer = new Serializer($normalizers, $encoders);

	    $repository = $this->getDoctrine()
	      ->getManager()
	      ->getRepository('DHPlatformBundle:Module');

	    $modules = $repository->findAll();

	    $jsonContent = $this->serializer->serialize($modules, 'json');

	    return new Response($jsonContent);
    	
    }
}
