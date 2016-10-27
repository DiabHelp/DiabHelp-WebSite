<?php


namespace Tests\DH\PlatformBundle\Controller;

use DH\PlatformBundle\Controller;
use Symfony\Bundle\SecurityBundle\Tests\Functional\WebTestCase;

class DiabhelpControllerTest extends WebTestCase
{
    public function testContact()
    {
        $contact = new Contact();
//        assert('')
    }

    protected $headers;

    protected function setUp()
    {
        $this->headers = array(
            'CONTENT_TYPE' => 'application/json',
        );
    }

    public function testAuthUser()
    {
        $client = static::createClient();

//        $client->request('POST', ...);

        // Check the response content type
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        // Assert that the response status code is 2xx
        $this->assertTrue($client->getResponse()->isSuccessful());

        $response = json_decode($client->getResponse()->getContent(), true);

        var_dump($response);die;
    }

}
