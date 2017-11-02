<?php

namespace Shogo\Auth_Session\Classes;

//Exit if accessed direShogo\Auth_Session\Classes\Bootstrap;ctly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class Form extends Bootstrap {

  //Form Tag with attributes.
  public function start() {

    return '<form method="POST" accept-charset="UTF-8"><input type="hidden" name="as_csrf" value="'. wp_create_nonce( 'as_nonce' ) .'" />';
  }

  //If User Access a Restricted Page Without Session, A message will appear in the Login Page.
  public function page_authorize( $msg = false ) {

    //If Has Redirect Page.
    if ( $_GET['redirect'] ) {

      //If Message is FALSE or not.
      if ( $msg ) {

        //Return String.
        return '<p class="AS_page_authorize_message">'. $msg .'</p>';
      } else {

        //Return String.
        return '<p class="AS_page_authorize_message">You are not authorize to access this page.</p>';
      }
    }
  }

  //Label Tag.
  public function label( $str = false ) {

    //If $str is FALSE or not.
    if ( empty( $str ) ) {

      //Set a Value.
      $str = 'Authentication Code:';
    }

    //Return String.
    return '<label for="auth_code" class="AS_login_label">'. $str .'</label>';
  }

  //Validation Message.
  public function validation_message( $validation = false ) {

    //Validation Error Property.
    $msg = self::$validation_error;

    //If has Message.
    if ( $msg ) {

      //If Message is empty.
      if ( $msg == 'empty' ) {

        //If $validation['empty'] is not NULL.
        if ( $validation['empty'] ) {

          //Return String.
          return $validation['empty'];
        } else {

          //Return String.
          return 'Please enter Authentication Code.';
        }

      //If Message is Invalid.
      } else if ( $msg == 'invalid' ) {

        //If $validation['invalid'] is not NULL.
        if ( $validation['invalid'] ) {

          //Return String.
          return $validation['invalid'];
        } else {

          //Return String.
          return 'Invalid Authentication Code.';
        }

      //If Message is Inactive.
      } else if ( $msg == 'inactive' ) {

        //If $validation['inactive'] is not NULL.
        if ( $validation['inactive'] ) {

          //Return String.
          return $validation['inactive'];
        } else {

          //Return String.
          return 'Authenication Code is Inactive.';
        }

      //If Message is Expired.
      } else if ( $msg == 'expired' ) {

        //If $validation['expired'] is not NULL.
        if ( $validation['expired'] ) {

          //Return String.
          return $validation['expired'];
        } else {

          //Return String.
          return 'Authentication Code is Expired.';
        }
      }

      //If Recaptcha Error.
      else if ( $msg == 'recaptcha_error' ) {

        //Plugin's options.
        $options = get_option( 'AS_Auth_Session' );

        //Decode JSON to PHP Array.
        $options = json_decode( $options, true );

        //If Validation is not empty.
        if ( ! empty( $options['as_options']['recapcha']['validation'] ) ) {

          return $options['as_options']['recapcha']['validation'];
        } else {

          return 'Please verify that you are a human.';
        }
      }
    }
  }

  //Authentication Code Text Field.
  public function auth_field( $attr = false ) {

    //If $attr['id'] is not NULL and $attr is ARRAY.
    if ( ! empty( $attr['id'] ) && is_array( $attr ) ) {

      //Set a Value.
      $id = 'id="'. $attr['id'] .'"';
    } else {

      //Value is NULL.
      $id = null;
    }

    //If $attr['class'] is not NULL and $attr is ARRAY.
    if ( ! empty( $attr['class'] ) && is_array( $attr ) ) {

      //Set a Value.
      $class = 'class="'. $attr['class'] .'"';
    } else {

      //Value is NULL.
      $class = null;
    }

    //If $attr['placeholder'] is not NULL and $attr is ARRAY.
    if ( ! empty( $attr['placeholder'] ) && is_array( $attr ) ) {

      //Set a Value.
      $placeholder = 'placeholder="'. $attr['placeholder'] .'"';
    } else {

      //Value is NULL.
      $placeholder = null;
    }

    //If $attr['autocomplete'] is not NULL and $attr is ARRAY.
    if ( ! empty( $attr['autocomplete'] ) && is_array( $attr ) ) {

      //Set a value.
      $autocomplete = 'autocomplete="'. $attr['autocomplete'] .'"';
    } else {

      //Value is NULL.
      $autocomplete = null;
    }

    //Return String with Attributes.
    return '<input type="text" name="as_auth" '. $id .' '. $class .' '. $placeholder .' '. $autocomplete .'  />';
  }

  //Submit Button.
  public function submit( $attr = false ) {

    //If $attr['id'] is not NULL and $attr is ARRAY.
    if ( ! empty( $attr['id'] ) && is_array( $attr ) ) {

      //Set a Value.
      $id = 'id="'. $attr['id'] .'"';
    } else {

      //Value is NULL.
      $id = null;
    }

    //If $attr['class'] is not NULL and $attr is ARRAY.
    if ( ! empty( $attr['class'] ) && is_array( $attr ) ) {

      //Set a Value.
      $class = 'class="'. $attr['class'] .'"';
    } else {

      //Value is NULL.
      $class = null;
    }

    //If $attr['value'] is not NULL and $attr is ARRAY.
    if ( ! empty( $attr['value'] ) ) {

      //Set a Value.
      $value = $attr['value'];
    } else {

      //Value is NULL.
      $value = 'Login';
    }

    //Return String with Attributes.
    return '<input type="submit" name="as_auth_login" value="'. $value .'" '. $id .' '. $class .' />';
  }

  public function recaptcha() {
    $recaptcha = new Recaptcha();

    return $recaptcha->form();
  }

  //Form End Tag.
  public function end() {

    //Return String.
    return '</form>';
  }
}
