<?php
//Myhome/UserBundle/Controller/loginAction.php
 
namespace DH\UserBundle\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Controller\SecurityController as BaseController;
 
class SecurityController extends BaseController
{
     public function loginAction(Request $request)
     {
        $logger = $this->get('logger');


        $logger->info('PREEEE : ' . print_r($_POST));
        if($request->isXmlHttpRequest()){
            $logger->info('POOOOST : ' . print_r($_POST));
        	// echo "AAAAAA";
            $response = new Response(json_encode(array(
                'success'=> $error == '' ? "1" : "0",
                'error'=> $this->container->get('translator')->trans($error)
            )));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
            exit();
        }
        return parent::loginAction($request);
     }
}