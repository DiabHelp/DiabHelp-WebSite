<?php
//Myhome/UserBundle/Controller/loginAction.php
 
namespace DH\UserBundle\Controller;
 
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Controller\SecurityController as BaseController;

class SecurityController extends BaseController
{
     // public function loginAction(Request $request)
     // {
     //    $logger = $this->get('logger');


     //    $logger->info('PREEEE : ' . print_r($_POST));
     //    if($request->isXmlHttpRequest()){
     //        $logger->info('POOOOST : ' . print_r($_POST));
     //    	// echo "AAAAAA";
     //        $response = new Response(json_encode(array(
     //            'success'=> $error == '' ? "1" : "0",
     //            'error'=> $this->container->get('translator')->trans($error)
     //        )));
     //        $response->headers->set('Content-Type', 'application/json');
     //        return $response;
     //        exit();
     //    }
     //    return parent::loginAction($request);
     // }

    public function restLoginAction(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        $em = $this->getDoctrine();
        $repo  = $em->getRepository("DHUserBundle:User"); //Entity Repository
        $user = $repo->findOneByUsername($username);
        if (!$user) {
            return new Response(json_encode(array("success" => false, "message" => "Invalid username")));
        } else {
            $token = new UsernamePasswordToken($user, $password, "main", $user->getRoles());
            $encoder_service = $this->get('security.encoder_factory');
            $encoder = $encoder_service->getEncoder($user);
            $encoded_pass = $encoder->encodePassword($password, $user->getSalt());
            if ($user->getPassword() != $encoded_pass) {
                return new Response(json_encode(array("success" => false, "message" => "Invalid password")));
            }
            // return new Response($token);
            $this->get("security.context")->setToken($token); //now the user is logged in
             
            //now dispatch the login event
            $request = $this->get("request");
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
            $sessionId = $this->get("session")->getId();
            $other = $this->container->get('security.context')->getToken();
            $id_user = $user->getId();
            $role = $user->getRoles();
            return new Response(json_encode(array("sessid" => $sessionId, "other" => $other, "id_user" => $id_user, "role" => $role)));
        }
    }

    // public function restLoginAction($secret) {
    //     $em = $this->getDoctrine()->getEntityManager();
    //     $repository = $em->getRepository('MiedzywodzieClientBundle:Reservation');
    //     $result = $repository->matchLoginKey($secret);
    //     if (!$result) {
    //         return $this->render('MiedzywodzieClientBundle:Default:autologin_incorrect.html.twig');
    //     }
    //     $result = $result[0]; 
 
    //     $token = new UsernamePasswordToken($result, $result->getPassword(), 'secured_area', $result->getRoles());
 
    //     $request = $this->getRequest();
    //     $session = $request->getSession();
    //     $session->set('_security_secured_area',  serialize($token));
 
    //     $router = $this->get('router');
    //     $url = $router->generate('miedzywodzie_client_default_dashboard');
 
    //     return $this->redirect($url);
    // }
}