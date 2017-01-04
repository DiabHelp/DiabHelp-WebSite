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
use Sensio\Bundle\BuzzBundle;

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
            $position = $user->getPosition();
            $response = array("success" => true, "position" => $position);
        }

        return new Response($this->serializer->serialize($response, 'json'));
    }

    public function alertAllProcheAction(Request $request, $id_patient) {
      $encoders = new JsonEncoder();
      $normalizer = new ObjectNormalizer();

      $normalizer->setCircularReferenceHandler(function ($object) {
          return $object;
      });

      $this->serializer = new Serializer(array($normalizer), array($encoders));

      $repository = $this->getDoctrine()
          ->getManager()
          ->getRepository('DHAPIBundle:ProchePatientLink');

      $links = $repository->findByPatient($id_patient);

      $errors = array();

      $repository = $this->getDoctrine()
          ->getManager()
          ->getRepository('DHAPIBundle:CdsSave');

      $entries = $repository->findByIdUser($id_patient);

      $message = $request->get('message', null);

      foreach ($links as $key => $link) {
        if ($link->getProche() != null) {
          $token = $link->getProche()->getFCMToken();
          $firstname = $link->getPatient()->getFirstname();
          $lastname = $link->getPatient()->getLastname();
          $position = $link->getPatient()->getPosition();

          if ($token != null || $firsname != null || $lastname != null || $position != null) {
            $url = 'https://fcm.googleapis.com/fcm/send';

            $to = $token;
            $pname = "fr.diabhelp.prochepatient";
            $appname = "Suivi des proches";
            $event = "alert_patient";
            $id_user = $id_proche;
            $name_user = $firstname . " " . $lastname;
            $id_patient = $id_patient;
            $cds = $entries;

            $datas = array("PNAME" => $pname,
                          "APPNAME" => $appname,
                          "EVENT" => $event,
                          "ID_USER" => $id_user,
                          "NAME_USER" => $name_user,
                          "ID_PATIENT" => $id_patient,
                          "MESSAGE" => $message,
                          "POSITION" => $position,
                          "CARNET_SUIVI" => $cds
                        );

            $data = array('to' => $to, 'datas'=> $datas);
            $data_json = json_encode($data);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
          }
        }
      }

      if ($message == null)
        $errors[] = "Missing message";
      if ($links == null)
        $errors[] = "Users not found";

      if (count($errors) > 0)
          $jsonContent = $this->serializer->serialize(array("success" => false, "errors" => $errors), 'json');
      else
          $jsonContent = $this->serializer->serialize(array("success" => true), 'json');

      return new Response($jsonContent);
    }

    public function alertOneProcheAction(Request $request, $id_patient, $id_proche) {
      $encoders = new JsonEncoder();
      $normalizer = new ObjectNormalizer();

      $normalizer->setCircularReferenceHandler(function ($object) {
          return $object;
      });

      $this->serializer = new Serializer(array($normalizer), array($encoders));

      $repository = $this->getDoctrine()
          ->getManager()
          ->getRepository('DHAPIBundle:ProchePatientLink');

      $links = $repository->findByPatient($id_patient);

      $errors = array();

      $message = $request->get('message', null);

      foreach ($links as $key => $link) {
        if ($id_proche == $link->getProche()->getId()) {
          $token = $link->getProche()->getFCMToken();
          $firstname = $link->getPatient()->getFirstname();
          $lastname = $link->getPatient()->getLastname();
          $position = $link->getPatient()->getPosition();

          $repository = $this->getDoctrine()
              ->getManager()
              ->getRepository('DHAPIBundle:CdsSave');

          $entries = $repository->findByIdUser($id_patient);

          $url = 'https://fcm.googleapis.com/fcm/send';

          $to = $token;
          $pname = "fr.diabhelp.prochepatient";
          $appname = "Suivi des proches";
          $event = "alert_patient";
          $id_user = $id_proche;
          $name_user = $firstname . " " . $lastname;
          $id_patient = $id_patient;
          $cds = $entries;

          $datas = array("PNAME" => $pname,
                        "APPNAME" => $appname,
                        "EVENT" => $event,
                        "ID_USER" => $id_user,
                        "NAME_USER" => $name_user,
                        "ID_PATIENT" => $id_patient,
                        "MESSAGE" => $message,
                        "POSITION" => $position,
                        "CARNET_SUIVI" => $cds
                      );

          $data = array('to' => $to, 'datas'=> $datas);
          $data_json = json_encode($data);

          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_exec($ch);
          curl_close($ch);
        }
      }

      if ($message == null)
        $errors[] = "Missing message";
      if ($links == null)
        $errors[] = "Users not found";

      if (count($errors) > 0)
          $jsonContent = $this->serializer->serialize(array("success" => false, "errors" => $errors), 'json');
      else
          $jsonContent = $this->serializer->serialize(array("success" => true), 'json');

      return new Response($jsonContent);
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

    public function setPatientPositionAction(Request $request) {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $this->serializer = new Serializer($normalizers, $encoders);

        $id_user = $request->get('id_user', null);
        $position = $request->get('position', null);

        $errors = array();
        if ($id_user == null || $position == null)
          $errors[] = "Missing parameters";
        else {
          $em = $this->getDoctrine()->getManager();
          $repo = $em->getRepository('DHUserBundle:User');
          $user = $repo->find($id_user);
          if ($user == null)
            $errors[] = "User not found";
        }

        if (count($errors) > 0) {
          $response = array("success" => false, "errors" => $errors);
          return new Response($this->serializer->serialize($response, 'json'));
        }

        if ($position)
          $user->setPosition($position);

        $em->persist($user);
        $em->flush();

        $response = array("success" => true);
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
