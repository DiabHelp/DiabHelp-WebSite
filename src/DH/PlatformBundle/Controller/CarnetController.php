<?php

namespace DH\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use DH\PlatformBundle\Entity\Logbook;

class CarnetController extends Controller
{
	private function generateRandomString($length = 42)
	{
    	return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	}

	public function exportJSONAction(Request $request)
	{
		$carnetToken = $this->generateRandomString();
		$path = $this->get('kernel')->getRootDir() . '/data/pdf/logbook/' . $carnetToken . '.pdf';
		$logbook = new Logbook();
		$user = $this->getUser();
		$logbook->setToken($carnetToken);
		$logbook->setDate(new \Datetime());
		$logbook->setUser($this->getUser());

		$firstname = $user->getFirstname();
		$lastname = $user->getLastname();

		$this->get('knp_snappy.pdf')->generateFromHtml(
	    $this->renderView(
	        'DHPlatformBundle:Carnet:template.html.twig',
	        array(
	            'firstname' => $firstname,
	            'lastname' => $lastname,
	            )
	        ),
	    $path
	    );

		$em = $this->getDoctrine()->getManager();
		$em->persist($logbook);

		$content = file_get_contents($path);

		$response = new Response();
	    $response->headers->set('Content-Type', 'application/pdf');
	    $response->headers->set('Content-Disposition', 'attachment;filename="'."Carnet_suivi_$firstname-$lastname.pdf");
	    $response->setContent($content);

		$em->flush();
	    return $response;
	}
}
