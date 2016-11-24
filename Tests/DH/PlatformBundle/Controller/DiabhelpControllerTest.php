<?php
namespace Tests\DH\PlatformBundle\Controller;

//use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class DiabhelpControllerTest extends WebTestCase
{
  public function testIndexAction()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/fr/home');
    $this->assertTrue($crawler->filter('html:contains("contact@diabhelp.org")')->count() > 0);
  }

  public function testLoginAction(){
    $client = static::createClient();
/*     $crawler = $this->client->request('GET', '/login');
     $form = $crawler->selectButton('_submit')->form(array(
     '_username'  => $username,
     '_password'  => $password,
     ));
     $this->client->submit($form);
     $this->assertTrue($this->client->getResponse()->isRedirect());
     $crawler = $this->client->followRedirect();*/
  }

  public function testLegalAction()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/fr/legal');
    $this->assertTrue($crawler->filter('html:contains("Mentions Légales")')->count() > 0);
  }

  public function testTheyHelpedUsAction()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/fr/theyHelpedUs');
    $this->assertTrue($crawler->filter('html:contains("Ils nous ont aidés")')->count() > 0);
  }

  public function testContactAction()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/fr/contact');
    //TODO Tester formulaire ==> réception du mail sur webmail ovh
//    var_dump($crawler);
    $form = $crawler->selectButton('Envoyer')->form();
/*    var_dump($form);
    // Try with good values
    $form['dh_platformbundle_contact[name]'] = 'UnitTest';
    $form['dh_platformbundle_contact[email]'] = 'ydrialz@gmail.com';
    $form['dh_platformbundle_contact[phone_number]'] = '0123456789';
    $form['dh_platformbundle_contact[body]'] = 'Hey there! I just wanted to test the contact form !';
    $crawler = $client->submit($form);*/
/*    $crawler = $client->submit($form, array(
    'dh_platformbundle_contact_name'     => 'PhpUnitTest',
    'dh_platformbundle_contact_email'  => 'ydrialz@gmail.com',
    'dh_platformbundle_contact_phone_number'  => '0987654321',
    'dh_platformbundle_contact_body' => 'Hey there! I just wanted to test the contact form !',
  ));*/


/*$client->request(
    'POST',
    '/contact',
    array(),
    array(),
    array('CONTENT_TYPE' => 'text/html'),
    '{"name":"PhpUnitTest", "email":"ydrialz@gmail.com", "phone_number":"0987654321", "body":"Hey there! I just wanted to test the contact form !"}'
);*/

    $this->assertTrue($crawler->filter('html:contains("Qui sommes nous ?")')->count() > 0);
  }
  public function testProfileAction()
  {
    //This page is only accessible when logged in
/*    $client = static::createClient();
    $crawler = $client->request('GET', '/fr/profile');
    $this->assertTrue($crawler->filter('html:contains("Modifier son profil")')->count() > 0);*/
    //TODO Modifications profil
  }

  public function testErrorPage()
  {
    $client = static::createClient();
    $crawler = $client->request('GET', '/fr/qsz');
    // Assert that the response status code is 404
    $this->assertTrue($client->getResponse()->isNotFound());
  }

  public function testForgetPwdAction()
  {
    //TODO
  }

  public function testCheckAvailableAction()
  {
    //Arg  : Request $request
    //TODO
  }

  public function checkEmailAndUsernameExistAction()
  {
    //Arg  : Request $request
    //TODO
  }
}
