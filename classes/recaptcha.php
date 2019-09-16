<?php

namespace Shogo\Auth_Session\Classes;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class Recaptcha {

  //Global recaptcha's enabled value.
  public $enabled;

  //Global recaptcha's site key.
  public $site_key;

  //Global recptcha's secret key.
  public $secret_key;

  //URL Recaptcha's verification.
  public $url;

  //The Constructor.
  public function __construct() {

    //Initiate Recaptcha's Instances.
    $this->init();
  }

  //Recaptcha's Intances.
  public function init() {

    //Plugin Options.
    $options = get_option( 'AS_auth_session' );

    //Decode JSON to PHP Array.
    $options = json_decode( $options, true );

    //Set Global site key.
    $this->site_key = $options['as_options']['recaptcha']['site_key'];

    //Set Global secret key.
    $this->secret_key = $options['as_options']['recaptcha']['secret_key'];

    //Set Global enabled value.
    $this->enabled = $options['as_options']['recaptcha']['enabled'];

    //Set Global URL recaptcha's verification.
    $this->url = 'https://www.google.com/recaptcha/api/siteverify';
  }

  //Recaptcha's Frontend checkbox.
  public function form() {
    if ( $this->enabled ) {
      return '<div id="recaptcha"></div>';
    }
  }

  //Recaptcha's Validation.
  public function validation() {
    if ( $_POST['g-recaptcha-response'] ) {

      //Post Datas.
      $data = [
        'secret' => $this->secret_key,
        'response' => $_POST['g-recaptcha-response'],
        'remoteip' => $_SERVER['REMOTE_ADDR'],
      ];

      $options = [
          'http' => [
              'header' => 'Content-type: application/x-www-form-urlencoded\r\n',
              'method' => 'POST',
              'content' => http_build_query($data),
          ],
      ];

      $context = stream_context_create($options);
      $response = file_get_contents($this->url, false, $context);
      $res = json_decode($response, true);

      if ($res['success']) {
        return 1;
      } else {
        return 0;
      }
    }
  }
}
