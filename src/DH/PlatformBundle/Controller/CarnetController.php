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
        return '
[{
   "date":"02/08/2016",
   "title":"test",
   "place":"test",
   "dateHour":"now",
   "glucide":0.2,
   "activity":"test",
   "activityType":"test",
   "notes":"test",
   "fastInsu":0.3,
   "slowInsu":0.4,
   "hba1c":0.5,
   "hour":"test",
   "glycemy":0.6,
   "breakfast":1,
   "lunch":0,
   "diner":0,
   "encas":0,
   "sleep":1,
   "wakeup":0,
   "night":0,
   "workout":0,
   "hypogly":0,
   "hypergly":0,
   "work":0,
   "athome":1,
   "alcohol":1,
   "period":0,
   "rdate":{
      "timezone":{
         "name":"Asia\/Hong_Kong",
         "location":{
            "country_code":"HK",
            "latitude":22.28333,
            "longitude":114.14999,
            "comments":""
         }
      },
      "offset":28800,
      "timestamp":1467281191
   },
   "idUser":1,
   "id":1,
   "idSynchro":1,
   "dateEdition":{
      "timezone":{
         "name":"Asia\/Hong_Kong",
         "location":{
            "country_code":"HK",
            "latitude":22.28333,
            "longitude":114.14999,
            "comments":""
         }
      },
      "offset":28800,
      "timestamp":1467216000
   }
}]';
    }

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

        $content = $this->renderView('DHPlatformBundle:Carnet:template.html.twig',
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

	public function exportJSONAction(Request $request)
	{
		$encoders = array(new XmlEncoder(), new JsonEncoder());
		$normalizers = array(new ObjectNormalizer());
		$this->serializer = new Serializer($normalizers, $encoders);

		$carnetToken = $this->generateRandomString();
		if (strncasecmp(PHP_OS, 'WIN', 3) == 0) {
			$path = $this->get('kernel')->getRootDir() . '\data\pdf\logbook\\' . $carnetToken . '.pdf';
		}
		else
			$path = $this->get('kernel')->getRootDir() . '/data/pdf/logbook/' . $carnetToken . '.pdf';

		$id_user = $request->get('id_user', null);
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
//        $datastring = $this->getFakeData();
//        $data = json_decode($datastring);

		$entries = $request->get('data', null);
		$data = json_decode($entries);

        $html = $this->renderView(
            'DHPlatformBundle:Carnet:template.html.twig',
            array(
                'firstname' => $firstname,
                'lastname' => $lastname,
                'data' => $data,
            )
        );

        $this->get('knp_snappy.pdf')->generateFromHtml($html, $path,
            array (
                'encoding' => 'utf-8',
                'dpi' => 300,
                'image-dpi' => 300
            ));

        $em = $this->getDoctrine()->getManager();
		$em->persist($logbook);

		$content = file_get_contents($path);

        $em->flush();
        $email = $request->get('email', null);
        if ($email == null)
            $email = $user->getEmail();
        if ($email){
//            $attachment = \Swift_Attachment::newInstance($content, "Carnet_suivi_$firstname-$lastname.pdf", 'application/pdf');
            $message = \Swift_Message::newInstance()
                ->setSubject('Votre carnet de suivi')
                ->setFrom('exportCDS@diabhelp.org')
                ->setTo($email)
                ->setBody($this->renderView('DHPlatformBundle:Mail:exportCDS.html.twig', array('enquiry' => $user)))
                ->attach(\Swift_Attachment::fromPath($path));
            $this->get('mailer')->send($message);
            return new Response($this->serializer->serialize(array("success" => true), 'json'));
        }
        else
            return new Response($this->serializer->serialize(array("success" => false), 'json'));
    }
}
