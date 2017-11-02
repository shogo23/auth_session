<?php

namespace Shogo\Auth_Session\Classes;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class Auth_Session {

  //Form property to Initiate AS_Form Class.
  public $Form;

  //Session property to Initiate AS_Session Class.
  public $Session;

  public function __construct() {

    //Initiate Form Class.
    $this->Form = new Form();

    //Initiate Session Class.
    $this->Session = new Session();
  }
}
