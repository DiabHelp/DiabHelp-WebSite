<?php

namespace DH\PlatformBundle\Controller;

use DH\PlatformBundle\Entity\Contact;
use DH\PlatformBundle\Form\ContactType;
use DH\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use DH\PlatformBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DiabhelpController extends Controller
{
    public function indexAction()
    {
        return $this->render('DHPlatformBundle:Diabhelp:index.html.twig');
    }

    public function legalAction()
    {
        return $this->render('DHPlatformBundle:Diabhelp:legal.html.twig');
    }

    public function theyHelpedUsAction()
    {
        return $this->render('DHPlatformBundle:Diabhelp:theyHelpedUs.html.twig');
    }

    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->get('form.factory')->create(new ContactType(), $contact);

        if ($request->getMethod() == 'POST') {

            if ($form->handleRequest($request)->isValid()) {

                if ($form->isValid()) {
                    $message = \Swift_Message::newInstance()
                        ->setSubject('Contact from DiabHelp website')
                        ->setFrom($contact->getEmail())
                        ->setTo('contact@diabhelp.org')
                        ->setBody($this->renderView('DHPlatformBundle:Mail:contact.html.twig', array('enquiry' => $contact)));
                    $this->get('mailer')->send($message);

//                    $this->get('session')->setFlash('blogger-notice', 'Votre message à bien été envoyé. Merci !');
                }

            }
        }

        return $this->render('DHPlatformBundle:Diabhelp:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function profileAction(Request $request)
    {
        $username = $this->getUser()->getUsername();

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('DHUserBundle:User')->findOneByUsername($username);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for username '. $username
            );
        }

        $userProfilePicturePath = $user->getProfilePicturePath();

        $form = $this->get('form.factory')->create(new UserType, $user);

        if ($form->handleRequest($request)->isValid()) {

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Profile has been modified');

            return $this->redirect($this->generateUrl('dh_platform_profile'));
        }

        return $this->render('DHPlatformBundle:Diabhelp:profile.html.twig', array(
            'form' => $form->createView(), 'userProfilePicturePath' => $userProfilePicturePath
        ));
    }

    public function forgetPwdAction()
    {
        return $this->render('DHPlatformBundle:Diabhelp:forgetPwd.html.twig');
    }

    public function checkAvailableAction(Request $request) {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $this->serializer = new Serializer($normalizers, $encoders);

        $username = $request->get('username', null);
        $email = $request->get('email', null);

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('DHUserBundle:User');

        $errors = array();
        if ($username == null)
            $errors[] = "Missing username";

        if ($email == null)
            $errors[] = "Missing email";

        $userByUsername = $repo->findByUsername($username);

        $userByEmail = $repo->findByEmail($email);

        if ($userByUsername == null && $userByEmail == null)
            $resp = array("success" => true);
        $availables = array(0 => 1, 1 => 1);
        if ($userByUsername != null)
            $availables[0] = 0;
        if ($userByEmail != null)
            $availables[1] = 0;
        if (count($errors) > 0 || $userByUsername != null || $userByEmail != null)
            $resp = array("success" => false, "errors" => $errors, "availables" => $availables);

        $jsonContent = $this->serializer->serialize($resp, 'json');
        return new Response($jsonContent);
    }

    public function checkEmailExistAction(Request $request) {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $this->serializer = new Serializer($normalizers, $encoders);

        $email = $request->get('email', null);

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('DHUserBundle:User');

        $errors = array();

        if ($email == null)
            $errors[] = "Missing email";

        $user = $repo->findByEmail($email);

        if (count($errors) > 0)
            $resp = array("success" => true, "errors" => $errors);
        else if ($user != null)
            $resp = array("success" => false);
        else
            $resp = array("success" => true);

        $jsonContent = $this->serializer->serialize($resp, 'json');
        return new Response($jsonContent);
    }
}
