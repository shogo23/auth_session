<?php

namespace Shogo\Auth_Session\Classes;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class Session extends Bootstrap {

  //Session Name Action.
  public function session_name() {

    //If User has Session.
    if ( $this->login_check() ) {

      //User's Session Details
      $details = $this->user_session_details();

      //Return String Session Name.
      return $details['session_name'];
    }
  }

  //Logout HyperText.
  public function destroy( $str = false ) {

    //If User has Session.
    if ( $this->login_check() ) {

      //If $str is not Empty.
      if ( empty( $str ) ) {

        //Set a Value.
        $str = 'Logout';
      }

      //Return String.
      return '<a href="'. get_site_url() .'/sa-session-logout">'. $str .'</a>';
    }


    //Return Nothing.
    return null;
  }

  //If User has Session Action.
  public function has_session() {

    if ( $_SESSION['Auth_Session']['AS_is_logged_in'] ) {
      return true;
    }

    return false;
  }
}
