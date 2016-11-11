<?php

namespace Tests\PlatformBundle\Resources\views\Diabhelp;

//use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DiabhelpControllerTest extends WebTestCase
{

  public function testNavBar()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/fr/home');


    $link = $crawler->selectLink('diabhelp_icon')->links();
    var_dump($link);
    $crawler = $client->click($link[0]);
    var_dump($crawler);
  }
}
