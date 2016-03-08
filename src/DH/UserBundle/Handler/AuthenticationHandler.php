<?php

namespace DH\UserBundle\Handler;

// use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
// use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
// use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
// use Symfony\Component\Routing\RouterInterface;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpFoundation\RedirectResponse;
// use Symfony\Component\Routing\Router;
// use Symfony\Component\Security\Core\SecurityContext;
// use Symfony\Component\Security\Core\Exception\AuthenticationException;


// class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
// {

//     protected $router;
//     protected $security;
//     protected $userManager;
//     protected $service_container;

//     public function __construct(RouterInterface $router, SecurityContext $security, $userManager, $service_container)
//     {
//         $this->router = $router;
//         $this->security = $security;
//         $this->userManager = $userManager;
//         $this->service_container = $service_container;

//     }
    
//     public function onAuthenticationSuccess(Request $request, TokenInterface $token) {
//         if ($request->isXmlHttpRequest()) {
//             $result = array('success' => true);
//             $response = new Response(json_encode($result));
//             $response->headers->set('Content-Type', 'application/json');
//             return $response;
//         }
//         else {
//             // Create a flash message with the authentication error message
//             // $request->getSession()->getFlashBag()->set('error', $exception->getMessage());
//             $url = $this->router->generate('dh_platform_home');

//             return new RedirectResponse($url);
//         }

//         return new RedirectResponse($this->router->generate('anag_new')); 
//     } 

//     public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
//         $result = array(
//             'success' => false, 
//             'function' => 'onAuthenticationFailure', 
//             'error' => true, 
//             'message' => $exception->getMessage() . ' -> ' . $_POST['username'] . ' - ' . $_POST['password']
//         );
//         $response = new Response(json_encode($result));
//         $response->headers->set('Content-Type', 'application/json');

//         return $response;
//     }
// }


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
 
class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{
    private $router;
    private $session;
 
    /**
     * Constructor
     *
     * @author  Joe Sexton <joe@webtipblog.com>
     * @param   RouterInterface $router
     * @param   Session $session
     */
    public function __construct( RouterInterface $router, Session $session )
    {
        $this->router  = $router;
        $this->session = $session;
    }
 
    /**
     * onAuthenticationSuccess
     *
     * @author  Joe Sexton <joe@webtipblog.com>
     * @param   Request $request
     * @param   TokenInterface $token
     * @return  Response
     */
    public function onAuthenticationSuccess( Request $request, TokenInterface $token )
    {
        // echo '<pre>';
        // echo (print_r($_POST));
        // var_dump($request);
        // echo '</pre>';
        // return new Response("");
        // if AJAX login
        if ( $request->isXmlHttpRequest() ) {
 
            $array = array( 'success' => true ); // data to return via JSON
            $response = new Response( json_encode( $array ) );
            $response->headers->set( 'Content-Type', 'application/json' );
 
            return $response;
 
        // if form login 
        } else {
 
            if ( $this->session->get('_security.main.target_path' ) ) {
 
                $url = $this->session->get( '_security.main.target_path' );
 
            } else {
 
                $url = $this->router->generate( 'dh_platform_home' );
 
            } // end if
 
            return new RedirectResponse( $url );
 
        }
    }
 
    /**
     * onAuthenticationFailure
     *
     * @author  Joe Sexton <joe@webtipblog.com>
     * @param   Request $request
     * @param   AuthenticationException $exception
     * @return  Response
     */
     public function onAuthenticationFailure( Request $request, AuthenticationException $exception )
    {
        // if ($request->isXmlHttpRequest())
        //     $isxml = "Yes, it's xmlhtttp, but : ";
        // else
        //     $isxml = " No, it's not xmlhtttp, but : ";
        // echo $isxml;
        // echo (print_r($_POST));
        // return new Response("AAAAAAAAAA " . $isxml);
        // if AJAX login
        if ( $request->isXmlHttpRequest() ) { 
            $array = array( 'success' => false, 'message' => $exception->getMessage() ); // data to return via JSON
            $response = new Response( json_encode( $array ) );
            $response->headers->set( 'Content-Type', 'application/json' );
 
            return $response;
 
        // if form login 
        } else {
            // set authentication exception to session
            $request->getSession()->set(SecurityContextInterface::AUTHENTICATION_ERROR, $exception);
 
            return new RedirectResponse( $this->router->generate( 'dh_platform_home' ) );
        }
    }
}