<?php

namespace DH\APIBundle\Controller;

use DH\APIBundle\Entity\ProchePatientLink;
use DH\APIBundle\Controller\CommonController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ProchePatientController extends Controller
{
    public function getAllPatientByUserIdAction(Request $request, $id_user) {
        $encoders = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });

        $this->serializer = new Serializer(array($normalizer), array($encoders));

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('DHAPIBundle:ProchePatientLink');

        $links = $repository->findByProche($id_user);

        foreach ($links as $key => $link) {
            $link->getPatient()->setPassword("");
            $link->getPatient()->setSalt("");
            $link->getProche()->setPassword("");
            $link->getProche()->setSalt("");
        }
        if ($links == null) {
            $errors[] = "Users not found";
            $jsonContent = $this->serializer->serialize(array("success" => false, "errors" => $errors), 'json');
        } else
            $jsonContent = $this->serializer->serialize(array("success" => true, "users" => $links), 'json');

        return new Response($jsonContent);
    }

    public function managePatientListAction(Request $request) {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $this->serializer = new Serializer($normalizers, $encoders);

        $errors = array();
        $id_proche = $request->get('id_proche', null);
        $id_patient = $request->get('id_patient', null);
        $status = $request->get('status', null);

        if ($id_proche == null)
            $errors[] = "Missing id_proche";
        if ($id_patient == null)
            $errors[] = "Missing id_patient";
        if ($status == null)
            $errors[] = "Missing status";

        if (count($errors) > 0) {
            $resp = array("success" => false, "errors" => $errors);
            $jsonContent = $this->serializer->serialize($resp, 'json');
            return new Response($jsonContent);
        }

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('DHAPIBundle:ProchePatientLink');

        $link = $repo->findOneBy(array(
            'proche' => $id_proche,
            'patient' => $id_patient
        ));

        if ($link == null) {
            $link = new ProchePatientLink();

            $user_repo = $em->getRepository('DHAPIBundle:User');

            $proche = $user_repo->findOneById($id_proche);
            $patient = $user_repo->findOneById($id_patient);

            if ($proche == null)
                $errors[] = "Proche not found";
            if ($patient == null)
                $errors[] = "Patient not found";

            if (count($errors) > 0) {
                $resp = array("success" => false, "errors" => $errors);
                $jsonContent = $this->serializer->serialize($resp, 'json');
                return new Response($jsonContent);
            }

            $link->setProche($proche);
            $link->setPatient($patient);
            $link->setStatus($status);
        } else
            $link->setStatus($status);

        $em->persist($link);
        $em->flush();

        return new Response($this->serializer->serialize(array("success" => true), 'json'));
    }

    public function getPatientPositionAction(Request $request, $id_user) {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $this->serializer = new Serializer($normalizers, $encoders);

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('DHUserBundle:User');

        $user = $repository->find($id_user);

        $errors = array();

        if ($user == null) {
            $errors[] = "User not found";
            $response = array("success" => false, "errors" => $errors);
        } else {
            $position = "Position";
            $response = array("success" => true, "position" => $position);
        }

        return new Response($this->serializer->serialize($response, 'json'));
    }

    public function searchPatientAction(Request $request, $id_user, $search) {
        $encoders = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });

        $this->serializer = new Serializer(array($normalizer), array($encoders));

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('DHUserBundle:User');

        $qb = $repository->createQueryBuilder('cm');
        $qb->select('cm')
            ->where($qb->expr()->orX(
                $qb->expr()->eq('cm.firstname', ':search'),
                $qb->expr()->eq('cm.lastname', ':search'),
                $qb->expr()->eq('cm.phone', ':search')
            ))
            ->setParameter('search', $search);

        $users = $qb->getQuery()->getResult();

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('DHAPIBundle:ProchePatientLink');

        $links = $repository->findByProche($id_user);

        foreach ($users as $key_u => $user) {
            foreach ($links as $key_l => $link) {
              if ($user->getId() == $link->getPatient()->getId()) {
                unset($users[$key_u]);
              }
            }
            $user->setPassword("");
            $user->setSalt("");
        }

        if ($users == null) {
            $errors = array();
            $errors[] = "Users not found";
            $jsonContent = $this->serializer->serialize(array("success" => false, "errors" => $errors), 'json');
        } else
            $jsonContent = $this->serializer->serialize(array("success" => true, "users" => $users), 'json');

        return new Response($jsonContent);
    }

    public function getAllProcheByUserIdAction(Request $request, $id_user) {
        $encoders = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });

        $this->serializer = new Serializer(array($normalizer), array($encoders));

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('DHAPIBundle:ProchePatientLink');

        $links = $repository->findByPatient($id_user);

        foreach ($links as $key => $link) {
            $link->getPatient()->setPassword("");
            $link->getPatient()->setSalt("");
            $link->getProche()->setPassword("");
            $link->getProche()->setSalt("");
        }
        if ($links == null) {
            $errors[] = "Users not found";
            $jsonContent = $this->serializer->serialize(array("success" => false, "errors" => $errors), 'json');
        } else
            $jsonContent = $this->serializer->serialize(array("success" => true, "users" => $links), 'json');

        return new Response($jsonContent);
    }

    public function manageProcheListAction(Request $request) {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $this->serializer = new Serializer($normalizers, $encoders);

        $errors = array();
        $id_proche = $request->get('id_proche', null);
        $id_patient = $request->get('id_patient', null);
        $status = $request->get('status', null);

        if ($id_proche == null)
            $errors[] = "Missing id_proche";
        if ($id_patient == null)
            $errors[] = "Missing id_patient";
        if ($status == null)
            $errors[] = "Missing status";

        if (count($errors) > 0) {
            $resp = array("success" => false, "errors" => $errors);
            $jsonContent = $this->serializer->serialize($resp, 'json');
            return new Response($jsonContent);
        }

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('DHAPIBundle:ProchePatientLink');

        $link = $repo->findOneBy(array(
            'proche' => $id_proche,
            'patient' => $id_patient
        ));

        if ($link == null) {
            $link = new ProchePatientLink();

            $user_repo = $em->getRepository('DHAPIBundle:User');

            $proche = $user_repo->findOneById($id_proche);
            $patient = $user_repo->findOneById($id_patient);

            if ($proche == null)
                $errors[] = "Proche not found";
            if ($patient == null)
                $errors[] = "Patient not found";

            if (count($errors) > 0) {
                $resp = array("success" => false, "errors" => $errors);
                $jsonContent = $this->serializer->serialize($resp, 'json');
                return new Response($jsonContent);
            }

            $link->setProche($proche);
            $link->setPatient($patient);
            $link->setStatus($status);
        } else
            $link->setStatus($status);

        $em->persist($link);
        $em->flush();

        return new Response($this->serializer->serialize(array("success" => true), 'json'));
    }

    public function setPatientPositionAction(Request $request, $id_user) {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $this->serializer = new Serializer($normalizers, $encoders);

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('DHUserBundle:User');

        $user = $repository->find($id_user);

        $errors = array();

        if ($user == null) {
            $errors[] = "User not found";
            $response = array("success" => false, "errors" => $errors);
        } else {
            $position = "Position";
            $response = array("success" => true, "position" => $position);
        }

        return new Response($this->serializer->serialize($response, 'json'));
    }

    public function searchProcheAction(Request $request, $id_user, $search) {
        $encoders = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });

        $this->serializer = new Serializer(array($normalizer), array($encoders));

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('DHUserBundle:User');

        $qb = $repository->createQueryBuilder('cm');
        $qb->select('cm')
            ->where($qb->expr()->orX(
                $qb->expr()->eq('cm.firstname', ':search'),
                $qb->expr()->eq('cm.lastname', ':search'),
                $qb->expr()->eq('cm.phone', ':search')
            ))
            ->setParameter('search', $search);

        $users = $qb->getQuery()->getResult();

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('DHAPIBundle:ProchePatientLink');

        $links = $repository->findByPatient($id_user);

        foreach ($users as $key_u => $user) {
            foreach ($links as $key_l => $link) {
              if ($user->getId() == $link->getProche()->getId()) {
                unset($users[$key_u]);
              }
            }
            $user->setPassword("");
            $user->setSalt("");
        }

        if ($users == null) {
            $errors = array();
            $errors[] = "Users not found";
            $jsonContent = $this->serializer->serialize(array("success" => false, "errors" => $errors), 'json');
        } else
            $jsonContent = $this->serializer->serialize(array("success" => true, "users" => $users), 'json');

        return new Response($jsonContent);
    }
}
