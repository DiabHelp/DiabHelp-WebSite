<?php
//Myhome/UserBundle/Controller/loginAction.php
 
namespace DH\UserBundle\Controller;
 
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SecurityController extends BaseController
{

    public function restLoginAction(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        $em = $this->getDoctrine();
        $repo  = $em->getRepository("DHUserBundle:User"); //Entity Repository
        $user = $repo->findOneByUsername($username);

        $errors = array();
        if ($username == null)
            $errors[] = "Missing username";
        if ($password == null)
            $errors[] = "Missing password";

        if (count($errors) > 0) {
            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
            $this->serializer = new Serializer($normalizers, $encoders);
            return new Response($this->serializer->serialize(array("success" => false, "errors" => $errors), 'json'));
        }

        if ($user) {
            $token = new UsernamePasswordToken($user, $password, "main", $user->getRoles());
            $encoder_service = $this->get('security.encoder_factory');
            $encoder = $encoder_service->getEncoder($user);
            $encoded_pass = $encoder->encodePassword($password, $user->getSalt());
            if ($user->getPassword() != $encoded_pass) {
                return new Response(json_encode(array("success" => false, "message" => $encoded_pass)));
            }
            $this->get("security.context")->setToken($token); //now the user is logged in
             
            $request = $this->get("request");
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
            $sessionId = $this->get("session")->getId();
            $other = $this->container->get('security.context')->getToken();
            $id_user = $user->getId();
            $role = $user->getRoles();
        }
        if (count($errors) > 0) {
            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
            $this->serializer = new Serializer($normalizers, $encoders);
            return new Response($this->serializer->serialize(array("success" => false, "errors" => $errors), 'json'));
        }
        return new Response(json_encode(array("success" => true, "sessid" => $sessionId, "other" => $other, "id_user" => $id_user, "role" => $role)));
    }

}