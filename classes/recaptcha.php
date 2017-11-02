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
      return '<div class="as_recaptcha g-recaptcha" data-sitekey="' . $this->site_key . '"></div>';
    }
  }

  //Recaptcha's Validation.
  public function validation() {

    //If Recaptcha has Response.
    if ( $_POST['g-recaptcha-response'] ) {

      //Recaptcha's Response.
      $response = $_POST['g-recaptcha-response'];

      //Recaptha's Data Verification Response.
      $data = $this->url . '?secret=' . $this->secret_key . '&response=' . $response . '&ip=' . $_SERVER['REMOTE_ADDR'];

      //Decode JSON to PHP Array.
      $data = json_decode( file_get_contents( $data ) );

      //If Verification Success.
      if ( $data->success ) {
        return 1;
      } else {
        return 0;
      }
    }
  }
}
