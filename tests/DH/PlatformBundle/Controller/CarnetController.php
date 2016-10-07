<?php

namespace DH\PlatformBundle\Controller;

use Swift_Mailer;
use Swift_MailTransport;
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

	public function indexAction(Request $request)
	{
		return $this->render('DHPlatformBundle:Carnet:index.html.twig');
	}

	public function showAction(Request $request){
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $this->serializer = new Serializer($normalizers, $encoders);
        $id_user = $request->get('id_user', null);
        $entries = $request->get('datas', null);
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('DHUserBundle:User');
        $user = $this->getUser();
        $datastring = $this->getFakeData();
        $data = json_decode($datastring);
//        $user = $repo->findOneById($id_user);
        if (!$user)
            return new Response($this->serializer->serialize(array("success" => false), 'json'));

        $firstname = $user->getFirstname();
        $lastname = $user->getLastname();

        $content = $this->renderView('DHAPIBundle:Carnet:template.html.twig',
            array(
                'firstname' => $firstname,
                'lastname' => $lastname,
                'data' => $data,
            )
        );
		$response = new Response();
		$response->headers->set('Content-Type', 'text/html');
		$response->setContent($content);
		return ($response);
	}

}
