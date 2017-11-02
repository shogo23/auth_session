<?php

use Shogo\Auth_Session\Classes\Auth_Session;

use Shogo\Auth_Session\Classes\Recaptcha as AS_Recaptcha;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class AS_Shortcodes {

  public function shortcode( $atts, $content = null ) {

    //For Login Page.
    if ( $atts['page'] == 'login' ) {

      //Initiate Auth_Session Class.
      $auth_session = new Auth_Session();

      //If auth_session.php via current theme is exists or not
      if ( ! file_exists( get_template_directory() . '/auth_session/auth_session.php' ) ) {
        ob_start();
        require_once( AS_PATH . 'includes/shortcodes_contents/login_page.php' );
        $output = ob_get_contents();
        ob_get_clean();
        ob_end_flush();

        return $output;
      } else {
        ob_start();
        require_once( get_template_directory() . '/auth_session/auth_session.php' );
        $output = ob_get_contents();
        ob_get_clean();
        ob_end_flush();

        return $output;
      }
    }

    //For Logout Page.
    if ( $atts['page'] == 'logout' ) {
      ob_start();
      require_once( AS_PATH . 'includes/shortcodes_contents/logout_page.php' );
      $output = ob_get_contents();
      ob_get_clean();
      ob_end_flush();

      return $output;
    }
  }

  public function welcome( $atts, $content = null ) {

    //Initiate Auth_Session Class.
    $auth_session = new Auth_Session();

    if ( $auth_session->Session->session_name() ) {
      return 'Welcome '. $auth_session->Session->session_name() . '!';
    }

    return null;
  }

  public function logout( $atts, $content ) {

    //Initiate Auth_Session Class.
    $auth_session = new Auth_Session();

    return $auth_session->Session->destroy();
  }
}
