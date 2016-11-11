<?php
namespace Tests\PlatformBundle\Controller;

//use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DiabhelpControllerTest extends WebTestCase
{
  public function testIndexAction()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/fr/home');
//    print_r($client->getResponse()->getContent());
    $this->assertContains('contact@diabhelp.org', $client->getResponse()->getContent());
  }


  public function testErrorPage()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/fr/qsz');
    // Assert that the response status code is 404
    $this->assertTrue($client->getResponse()->isNotFound());
  }
}
