<?php

namespace DH\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use DH\PlatformBundle\Entity\Logbook;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CarnetController extends Controller
{
	private function generateRandomString($length = 42)
	{
    	return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	}

	private function getFakeData()
	{
		return '[{"title": "Un titre","glucide": 13.0,"activity": "une activité","activityType": "un type d\'activité","notes": "Une note","date": "17-janv.-2016","fast_insu": 0.02,"slow_insu": 0.03,"hba1c": 2.0,"hour": "23:56","glycemy": 32.4},{"title": "Un titre","glucide": 13.0,"activity": "une activité","activityType": "un type d\'activité","notes": "Une note","date": "17-janv.-2016","fast_insu": 0.02,"slow_insu": 0.03,"hba1c": 2.0,"hour": "23:56","glycemy": 32.4}]';
	}

	public function indexAction(Request $request)
	{
		return $this->render('DHPlatformBundle:Carnet:index.html.twig');
	}

	public function exportJSONAction(Request $request)
	{
		$encoders = array(new XmlEncoder(), new JsonEncoder());
		$normalizers = array(new ObjectNormalizer());
		$this->serializer = new Serializer($normalizers, $encoders);

		$carnetToken = $this->generateRandomString();
		$path = $this->get('kernel')->getRootDir() . '/data/pdf/logbook/' . $carnetToken . '.pdf';

		$id_user = $request->get('id_user', null);
		$entries = $request->get('datas', null);
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository('DHUserBundle:User');
		$user = $repo->findOneById($id_user);

		if (!$user)
			return new Response($this->serializer->serialize(array("success" => false), 'json'));

		$logbook = new Logbook();
		$logbook->setToken($carnetToken);
		$logbook->setDate(new \Datetime());
		$logbook->setUser($user);

		$firstname = $user->getFirstname();
		$lastname = $user->getLastname();

		$datas = json_decode($entries);

		$this->get('knp_snappy.pdf')->generateFromHtml(
	    $this->renderView(
	        'DHPlatformBundle:Carnet:template.html.twig',
	        array(
	            'firstname' => $firstname,
	            'lastname' => $lastname,
	            'datas' => $datas,
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
