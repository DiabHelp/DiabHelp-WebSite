<?php

namespace DH\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CarnetController extends Controller
{

    public function exportAction(Request $request, $id, $entries)
    {
        $encoders = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });

        $this->serializer = new Serializer(array($normalizer), array($encoders));

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('DHPlatformBundle:Module');

        $module = $repository->find($id);

        if ($module == null) {
            throw new NotFoundHttpException("Le module " . $id . " n'existe pas.");
        }

        $jsonContent = $this->serializer->serialize($module, 'json');

        return new Response($jsonContent);
    }

    public function downloadAction(Request $request, $id)
    {
        $encoders = new JsonEncoder();
        $normalizer = new ObjectNormalizer();

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });

        $this->serializer = new Serializer(array($normalizer), array($encoders));

        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('DHPlatformBundle:Module');

        $module = $repository->find($id);

        if ($module == null) {
            throw new NotFoundHttpException("Le module " . $id . " n'existe pas.");
        }

        $jsonContent = $this->serializer->serialize($module, 'json');

        return new Response($jsonContent);
    }

}
