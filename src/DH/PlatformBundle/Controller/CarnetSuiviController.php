<?php

namespace DH\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CarnetSuiviController extends Controller
{
	public function exportJSONAction(Request $request)
	{
		// A FAIre ...
		$this->get('knp_snappy.pdf')->generateFromHtml(
	    $this->renderView(
	        'MyBundle:Foo:bar.html.twig',
	        array(
	            'some'  => $vars
	            )
	        ),
	    '/path/to/the/file.pdf'
		);
	}
}