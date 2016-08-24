<?php

namespace DH\AdminBundle\Controller;

use DH\PlatformBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('DHUserBundle:User');

        $users = $repository->findAll();

        return $this->render('DHAdminBundle:User:index.html.twig', array('users' => $users));
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('DHUserBundle:User')->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id ' . $id
            );
        }

        $form = $this->get('form.factory')->create(new UserType, $user);

        if ($form->handleRequest($request)->isValid()) {

            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'User has been modified');

            return $this->redirect($this->generateUrl('dh_admin_users'));
        }

        return $this->render('DHAdminBundle:User:add.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('DHUserBundle:User')->find($id);

        if ($user) {
            $em->remove($user);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'User supprimé avec success');
        }
        else {
            $request->getSession()->getFlashBag()->add('info', 'Invalid userID');
        }
        return $this->redirect($this->generateUrl('dh_admin_users'));
    }
}
