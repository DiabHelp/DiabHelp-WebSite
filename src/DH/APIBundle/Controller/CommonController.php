<?php

namespace DH\APIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PushNotification extends Controller {

  private $destination;
  private $title;
  private $body;

  public function setDestination($destination) {
    $this.$destination = $destination;
    return this;
  }

  public function setDestination($title) {
    $this.$title = $title;
    return this;
  }

  public function setDestination($body) {
    $this.$body = $body;
    return this;
  }

  public function send() {
    // $message = "the test message";
    // $tickerText = "ticker text message";
    // $contentTitle = "content title";
    // $contentText = "content body";
    //
    // $registrationId = 'abcdef...';
    $apiKey = "1234...";

    $headers = array("Content-Type:" . "application/json", "Authorization:" . "key=" . $apiKey);

    $data = array(
        'data' => $this.$body,
        'registration_ids' => $this.$destination
    );

    $ch = curl_init();

    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch, CURLOPT_URL, "https://android.googleapis.com/gcm/send" );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($data) );

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
  }

}

?>
