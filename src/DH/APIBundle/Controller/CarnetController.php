<?php

namespace DH\APIBundle\Controller;

use DH\APIBundle\Entity\CdsSave;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
            throw new NotFoundHttpException("L'id user " . $id_user . " n'a aucune entrées.");
        }

        $jsonContent = $this->serializer->serialize($entries, 'json');

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
            throw new NotFoundHttpException("L'id user " . $id_user . " n'a aucune entrées.");
        }

        $jsonContent = $this->serializer->serialize($entry->getDateEdition(), 'json');

        return new Response($jsonContent);
    }

    public function setFromAppAction(Request $request)
    {
        $encoders = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $this->serializer = new Serializer(array($normalizer), array($encoders));

        $em = $this->getDoctrine()
            ->getManager();

        $repository = $em->getRepository('DHAPIBundle:CdsSave');

        $id_user = $request->request->get('id_user', null);
        $entries = $request->request->get('entries', null);

        foreach ($entries as $entry) {
            $entry_insert = new CdsSave();
            $entry_insert->setIdSynchro($entry['id']);
            $entry_insert->setIdUser($id_user);
            $entry_insert->setDateEdition($entry['date_edition']);
            $entry_insert->setTitle($entry['title']);
            $entry_insert->setPlace($entry['place']);
            $entry_insert->setDateHour($entry['date_hour']);
            $entry_insert->setGlucide($entry['glucide']);
            $entry_insert->setActivity($entry['activity']);
            $entry_insert->setActivityType($entry['activity_type']);
            $entry_insert->setNotes($entry['notes']);
            $entry_insert->setFastInsu($entry['fast_insu']);
            $entry_insert->setSlowInsu($entry['slow_insu']);
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
            $entry_insert->setHypergly($entry['hupergly']);
            $entry_insert->setWork($entry['work']);
            $entry_insert->setAthome($entry['athome']);
            $entry_insert->setAlcohol($entry['alcohol']);
            $entry_insert->setPeriod($entry['period']);
            $entry_insert->setRdate($entry['rdate']);

            $em->persist($entry_insert);
            $em->flush();
        }

        if ($repository == null) {
            return new Response($this->serializer->serialize(array("status" => "error"), 'json'));
        }

        return new Response($this->serializer->serialize(array("status" => "success"), 'json'));
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
            return new Response($this->serializer->serialize(array("status" => "error"), 'json'));
        }

        $em->remove($entry);
        $em->flush();

        return new Response($this->serializer->serialize(array("status" => "success"), 'json'));
    }

    public function exportAction(Request $request, $id, $entries)
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

        $jsonContent = $this->serializer->serialize($module, 'json');

        return new Response($jsonContent);
    }

    public function downloadAction(Request $request, $id)
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

        $jsonContent = $this->serializer->serialize($module, 'json');

        return new Response($jsonContent);
    }

}
