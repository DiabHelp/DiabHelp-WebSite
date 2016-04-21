<?php

namespace DH\APIBundle\Controller;

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
        $username = $request->request->get('username', null);
        $password = $request->request->get('password', null);
        $email = $request->request->get('email', null);
        $firstname = $request->request->get('firstname', null);
        $lastname = $request->request->get('lastname', null);
        $role = $request->request->get('role', null);

        $userManager = $this->container->get('fos_user.user_manager');
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('DHUserBundle:User');

    	if (!$username && strlen($username) < 42 && strlen($username) > 3)
            $errors[] = "Invalid username";
        else {
            $user = $repo->findByUsername($username);
            if ($user)
                $errors[] = "Username already use";
        }
        if (!$email)
            $errors[] = "Invalid email";
        else {
            $user = $repo->findByEmail($email);
            if ($user)
                $errors[] = "email already use";
        }
        if (!$password && strlen($password) < 42 && strlen($password) > 3)
            $errors[] = "Invalid password";
        if (!$firstname && strlen($firstname) < 42 && strlen($firstname) > 3)
            $errors[] = "Invalid firstname";
        if (!$lastname && strlen($lastname) < 42 && strlen($lastname) > 3)
            $errors[] = "Invalid lastname";
        if (!($role == "ROLE_PATIENT" || $role == "ROLE_PROCHE" || $role == "ROLE_DOCTOR" || $role == "ROLE_ADMIN"))
            $errors[] = "Invalid role";

        if (count($errors) > 0) {
            $resp = array("status" => "error", "errors" => $errors);
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
        $user->setEnabled(true);

        // $userManager->updateUser($user);
        $em->persist($user);
        $em->flush();

        return new Response($this->serializer->serialize(array("status" => "success"), 'json'));
        // $user = new User();        
        // // $form = $this->createForm(new RegistrationType(), $user);
        // $form = $this->get('form.factory')->create(new RegistrationType, $user);
        // $form->submit($request);
        // $form->handleRequest($request);
        // if($form->isValid()) {
        //     $userManager = $this->get('fos_user.user_manager');
        //     $exists = $userManager->findUserBy(array('email' => $user->getEmail()));
        //     if ($exists instanceof User) {
        //         throw new HttpException(409, 'Email already taken');
        //     }
        //     // print_r($user);
        //     // return new Response("");
        //     $userManager->updateUser($user);
        //     return new Response($this->serializer->serialize(array("status" => "success"), 'json'));
        // }
        // return new Response($this->serializer->serialize(array("status" => "fail", "errors" => $form->getErrors()), 'json'));
    }

    public function logoutAction(Request $request, $token) {
        $encoders = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });

        $this->serializer = new Serializer(array($normalizer), array($encoders));

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('DHUserBundle:User');

        $user = $repository->findByToken($token);

        if ($user == null) {
            throw new NotFoundHttpException("Le token " . $token . " n'existe pas.");
        }

        $repository->emptyAuthToken($user->getId());

        $jsonContent = $this->serializer->serialize("true", 'json');

        return new Response($jsonContent);
    }

}
