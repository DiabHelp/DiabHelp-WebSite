<?php

namespace DH\APIBundle\Controller;

use DateTime;
use DH\APIBundle\Entity\CdsSave;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Swift_MailTransport;

class CarnetController extends Controller
{

    public function getAllEntryByUserIdAction(Request $request, $id_user)
    {
        $encoders = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });

        $this->serializer = new Serializer(array($normalizer), array($encoders));

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('DHAPIBundle:CdsSave');

        $entries = $repository->findByIdUser($id_user);

        if ($entries == null) {
            return new Response($this->serializer->serialize(array("success" => false), 'json'));
        }

        foreach ($entries as $entry) {
            if ($entry->getDateEdition() != null)
                $entry->setDateEdition($entry->getDateEdition()->getTimestamp());
            if ($entry->getDateCreation() != null)
                $entry->setDateCreation($entry->getDateCreation()->getTimestamp());
        }

        $jsonContent = $this->serializer->serialize(array("success" => true, "entries" => $entries), 'json');

        return new Response($jsonContent);
    }

    public function getLastDateAction(Request $request, $id_user)
    {
        $encoders = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });

        $this->serializer = new Serializer(array($normalizer), array($encoders));

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('DHAPIBundle:CdsSave');

        $entry = $repository->findOneBy(
            array('idUser' => $id_user),
            array('dateEdition' => 'desc')
        );

        if ($entry == null) {
            return new Response($this->serializer->serialize(array("success" => false), 'json'));
        }

        $entry->setDateEdition($entry->getDateEdition()->getTimestamp());

        $jsonContent = $this->serializer->serialize(array("success" => true, "dateEdition" => $entry->getDateEdition()), 'json');

        return new Response($jsonContent);
    }

    public function setFromAppAction(Request $request, $id_user)
    {
        $encoders = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $this->serializer = new Serializer(array($normalizer), array($encoders));

        $em = $this->getDoctrine()
            ->getManager();

        $repository = $em->getRepository('DHAPIBundle:CdsSave');

        $entries = array();
        $content = $this->get("request")->getContent();
        if (!empty($content)) {
            $entries = json_decode($content, true);
        }

        if ($id_user == null || $content == null) {
            return new Response($this->serializer->serialize(array("success" => false), 'json'));
        }

        foreach ($entries as $entry) {
            $test_entry = $repository->findOneBy(array(
                'idSynchro' => $entry['id'],
                'idUser' => $id_user,
            ));

            if ($test_entry == null) {
                $entry_insert = new CdsSave();
                $tmp_date = new DateTime();
                $entry_insert->setIdSynchro($entry['id']);
                $entry_insert->setIdUser($id_user);
                $date = $tmp_date->setTimestamp($entry['dateCreation']);
                $entry_insert->setDateCreation($date);
                $date_edition = $tmp_date->setTimestamp($entry['dateEdition']);
                $entry_insert->setDateEdition($date_edition);
                $entry_insert->setTitle($entry['title']);
                $entry_insert->setPlace($entry['place']);
                $entry_insert->setGlucide($entry['glucide']);
                $entry_insert->setActivity($entry['activity']);
                $entry_insert->setActivityType($entry['activityType']);
                $entry_insert->setNotes($entry['notes']);
                $entry_insert->setFastInsu($entry['fastInsu']);
                $entry_insert->setSlowInsu($entry['slowInsu']);
                $entry_insert->setHba1c($entry['hba1c']);
                $entry_insert->setHour($entry['hour']);
                $entry_insert->setGlycemy($entry['glycemy']);
                $entry_insert->setBreakfast($entry['breakfast']);
                $entry_insert->setLunch($entry['lunch']);
                $entry_insert->setDiner($entry['diner']);
                $entry_insert->setEncas($entry['encas']);
                $entry_insert->setSleep($entry['sleep']);
                $entry_insert->setWakeup($entry['wakeup']);
                $entry_insert->setNight($entry['night']);
                $entry_insert->setWorkout($entry['workout']);
                $entry_insert->setHypogly($entry['hypogly']);
                $entry_insert->setHypergly($entry['hypergly']);
                $entry_insert->setWork($entry['work']);
                $entry_insert->setAthome($entry['athome']);
                $entry_insert->setAlcohol($entry['alcohol']);
                $entry_insert->setPeriod($entry['period']);

                $em->persist($entry_insert);
                $em->flush();
            } else if ($test_entry->getDateEdition()->getTimestamp() < $entry['dateEdition']) {
                $tmp_date = new DateTime();
                $test_entry->setIdSynchro($entry['id']);
                $test_entry->setIdUser($id_user);
                $date = $tmp_date->setTimestamp($entry['dateCreation']);
                $test_entry->setDateCreation($date);
                $date_edition = $tmp_date->setTimestamp($entry['dateEdition']);
                $test_entry->setDateEdition($date_edition);
                $test_entry->setTitle($entry['title']);
                $test_entry->setPlace($entry['place']);
                $test_entry->setGlucide($entry['glucide']);
                $test_entry->setActivity($entry['activity']);
                $test_entry->setActivityType($entry['activityType']);
                $test_entry->setNotes($entry['notes']);
                $test_entry->setFastInsu($entry['fastInsu']);
                $test_entry->setSlowInsu($entry['slowInsu']);
                $test_entry->setHba1c($entry['hba1c']);
                $test_entry->setHour($entry['hour']);
                $test_entry->setGlycemy($entry['glycemy']);
                $test_entry->setBreakfast($entry['breakfast']);
                $test_entry->setLunch($entry['lunch']);
                $test_entry->setDiner($entry['diner']);
                $test_entry->setEncas($entry['encas']);
                $test_entry->setSleep($entry['sleep']);
                $test_entry->setWakeup($entry['wakeup']);
                $test_entry->setNight($entry['night']);
                $test_entry->setWorkout($entry['workout']);
                $test_entry->setHypogly($entry['hypogly']);
                $test_entry->setHypergly($entry['hypergly']);
                $test_entry->setWork($entry['work']);
                $test_entry->setAthome($entry['athome']);
                $test_entry->setAlcohol($entry['alcohol']);
                $test_entry->setPeriod($entry['period']);

                $em->flush();
            }
        }

        return new Response($this->serializer->serialize(array("success" => true), 'json'));
    }

    public function deleteAction(Request $request, $id, $id_user)
    {
        $encoders = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $this->serializer = new Serializer(array($normalizer), array($encoders));

        $em = $this->getDoctrine()
            ->getManager();

        $repository = $em->getRepository('DHAPIBundle:CdsSave');

        $entry = $repository->findOneBy(
            array('idUser' => $id_user, 'idSynchro' => $id)
        );

        if ($repository == null || $entry == null) {
            return new Response($this->serializer->serialize(array("success" => false), 'json'));
        }

        $em->remove($entry);
        $em->flush();

        return new Response($this->serializer->serialize(array("success" => true), 'json'));
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

        $firstname = $user->getFirstname();
        $lastname = $user->getLastname();

        $data = array();
        $content = $this->get("request")->getContent();
        if (!empty($content)) {
            $data = json_decode($content, true);
        }

        if ($id_user == null || $content == null)
            return new Response($this->serializer->serialize(array("success" => false), 'json'));

        $html = $this->renderView(
            'DHAPIBundle:Carnet:template.html.twig',
            array(
                'firstname' => $firstname,
                'lastname' => $lastname,
                'data' => $data,
            )
        );
        $this->get('knp_snappy.pdf')->generateFromHtml($html, $path,
            array (
                'orientation'=>'Landscape',
                'encoding' => 'utf-8',
                'dpi' => 300,
                'image-dpi' => 300
            ));

        $transport = Swift_MailTransport::newInstance();
        $mailer = Swift_Mailer::newInstance($transport);
        $email = $request->get('email', null);
        $datenow = new \DateTime();
        if ($email == null)
            $email = $user->getEmail();
        if ($email){
            $filename = "Export-". $firstname. "-" . $lastname . "-" . $datenow->format('Y-m-d H:i:s') . ".pdf";
            $message = \Swift_Message::newInstance()
                ->setSubject('Votre carnet de suivi')
                ->setFrom('exportCDS@diabhelp.org')
                ->setBody($this->renderView('DHAPIBundle:Mail:exportCDS.html.twig', array('enquiry' => $user)))
                ->attach(\Swift_Attachment::fromPath($path)->setFilename($filename));
            $message->setTo($email);
            $mailer->send($message);
            return new Response($this->serializer->serialize(array("success" => true), 'json'));
        }
        else
            return new Response($this->serializer->serialize(array("success" => false), 'json'));
    }

    private function generateRandomString($length = 42)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }
}
