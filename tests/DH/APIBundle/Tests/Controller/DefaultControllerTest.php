<?php

namespace DH\APIBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/hello/Fabien');

        $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);

        // Assert that there is at least one h2 tag
// with the class "subtitle"
        $this->assertGreaterThan(
            0,
            $crawler->filter('h2.subtitle')->count()
        );

// Assert that there are exactly 4 h2 tags on the page
        $this->assertCount(4, $crawler->filter('h2'));

// Assert that the "Content-Type" header is "application/json"
        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            ),
            'the "Content-Type" header is "application/json"' // optional message shown on failure
        );

// Assert that the response content contains a string
        $this->assertContains('foo', $client->getResponse()->getContent());
// ...or matches a regex
        $this->assertRegExp('/foo(bar)?/', $client->getResponse()->getContent());

// Assert that the response status code is 2xx
        $this->assertTrue($client->getResponse()->isSuccessful(), 'response status is 2xx');
// Assert that the response status code is 404
        $this->assertTrue($client->getResponse()->isNotFound());
// Assert a specific 200 status code
        $this->assertEquals(
            200, // or Symfony\Component\HttpFoundation\Response::HTTP_OK
            $client->getResponse()->getStatusCode()
        );

// Assert that the response is a redirect to /demo/contact
        $this->assertTrue(
            $client->getResponse()->isRedirect('/demo/contact'),
            'response is a redirect to /demo/contact'
        );
// ...or simply check that the response is a redirect to any URL
        $this->assertTrue($client->getResponse()->isRedirect());

    }
}
