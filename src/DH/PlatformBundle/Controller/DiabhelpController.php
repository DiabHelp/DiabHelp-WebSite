<?php

namespace DH\PlatformBundle\Controller;

use DH\PlatformBundle\Entity\Contact;
use DH\PlatformBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
//                $form->bindRequest($request);

                if ($form->isValid()) {
                    $message = \Swift_Message::newInstance()
                        ->setSubject('Contact from DiabHelp website')
                        ->setFrom('contact@diabhelp.fr')
                        ->setTo('adrien.vigour@gmail.com')
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
    
    public function profileAction()
    {
        return $this->render('DHPlatformBundle:Diabhelp:profile.html.twig');
    }

    public function forgetPwdAction()
    {
        return $this->render('DHPlatformBundle:Diabhelp:forgetPwd.html.twig');
    }
}
