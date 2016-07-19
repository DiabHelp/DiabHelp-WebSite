<?php

namespace DH\APIBundle\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Serializer;

class UserController extends Controller
{
    public function registerAction(Request $request)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $this->serializer = new Serializer($normalizers, $encoders);

        $errors = array();
        $username = $request->get('username', null);
        $password = $request->get('password', null);
        $email = $request->get('email', null);
        $firstname = $request->get('firstname', null);
        $lastname = $request->get('lastname', null);
        $role = $request->get('role', null);

        $userManager = $this->container->get('fos_user.user_manager');
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('DHUserBundle:User');

        if ($username == null)
            $errors[] = "Missing username";
        if ($password == null)
            $errors[] = "Missing password";
        if ($email == null)
            $errors[] = "Missing email";
        if ($firstname == null)
            $errors[] = "Missing firstname";
        if ($lastname == null)
            $errors[] = "Missing lastname";
        if ($role == null)
            $errors[] = "Missing role";

        $user = $repo->findByUsername($username);
        if ($user)
            $errors[] = "Username already used";
        $user = $repo->findByEmail($email);
        if ($user)
            $errors[] = "Email already used";

        if (count($errors) > 0) {
            $resp = array("success" => false, "errors" => $errors);
            $jsonContent = $this->serializer->serialize($resp, 'json');
            return new Response($jsonContent);
        }
        $user = $userManager->createUser();
        $user->setUsername($username);
        $user->setPlainPassword($password);
        $user->setEmail($email);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->addRole($role);
        $user->setProfilePicturePath("defaulf.jpg");
        $user->setEnabled(true);

        // $userManager->updateUser($user);
        $em->persist($user);
        $em->flush();

        return new Response($this->serializer->serialize(array("success" => true), 'json'));
    }

    public function logoutAction(Request $request, $token) {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $this->serializer = new Serializer($normalizers, $encoders);

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('DHUserBundle:User');

        $user = $repository->findByToken($token);

        if ($user == null) {
            return new Response($this->serializer->serialize(array("success" => false), 'json'));
        }

        $repository->emptyAuthToken($user->getId());

        return new Response($this->serializer->serialize(array("success" => true), 'json'));
    }

    public function getInfoAction(Request $request, $id) {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $this->serializer = new Serializer($normalizers, $encoders);

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('DHUserBundle:User');

        $user = $repository->find($id);

        if ($user == null) {
            return new Response($this->serializer->serialize(array("success" => false), 'json'));
        }

        $user->setPassword("");
        $user->setSalt("");

        if ($user->getBirthDate() != null)
            $user->setBirthDate($user->getBirthDate()->format('Y-m-d H:i:s'));

        $jsonContent = $this->serializer->serialize(array("success" => true, 'user' => $user), 'json');

        return new Response($jsonContent);
    }

    public function setInfoAction(Request $request) {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $this->serializer = new Serializer($normalizers, $encoders);

        $id = $request->get('id', null);
        $username = $request->get('username', null);
        $password = $request->request->get('password', null);
        $passwordv = $request->request->get('passwordv', null);
        $email = $request->get('email', null);
        $firstname = $request->get('firstname', null);
        $lastname = $request->get('lastname', null);
        $phone = $request->get('phone', null);
        $birthdate = $request->get('birthdate', null);
        $organisme = $request->get('organisme', null);

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('DHUserBundle:User');

        if ($id && $id != "")
            $user = $repo->findOneById($id);
        if ($username && $username != "")
            $user->setUsername($username);
        if ($password && $passwordv && $password == $passwordv && $password != "")
            $user->setPlainPassword($password);
        if ($email && $email != "")
            $user->setEmail($email);
        if ($firstname && $firstname != "")
            $user->setFirstname($firstname);
        if ($lastname && $lastname != "")
            $user->setLastname($lastname);
        if ($phone && $phone != "")
            $user->setPhone($phone);
        if ($birthdate && $birthdate != "")
            $user->setBirthdate($birthdate);
        if ($organisme && $organisme != "")
            $user->setOrganisme($organisme);

        $em->flush();

        return new Response($this->serializer->serialize(array("success" => true), 'json'));
    }

}
