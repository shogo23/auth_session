<?php

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

//Import Action Class.
use Shogo\Auth_Session\Classes\Actions;

function Shogo_AS_ajax() {

    $operation = $_POST['operation'];

  switch ( $operation ) {

    //Add Auth Session.
    case 'add_auth_session':

      //Initiate AS_Action Class.
      $action = new Actions();

      //Session name.
      $session_name = $_POST['session_name'];

      //Session Authentication Code.
      $session_auth = $_POST['session_auth'];

      //Start Date. Converted to Datetime Format.
      $start_date = $action->toDatetime( $_POST['start_time'] );

      //End Date. Converted to Date Format.
      $end_date = $action->toDatetime( $_POST['end_time'] );

      //Data Values.
      $data = [
        'session_name' => $session_name,
        'session_auth' => $session_auth,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'created' => date( 'Y-m-d H:i:s' )
      ];

      //Binds Values.
      $binds = [ '%s', '%s', '%s', '%s', '%s' ];

      //Insert Data to Database.
      $action->insert_to_db( $data, $binds );

      //Return value from ajax request.
      echo 'ok';
    break;

    //Edit Session Action.
    case 'edit_auth_session':

      //Initiate AS_Action Class.
      $action = new Actions();

      //Session ID.
      $id = (int)$_POST['id'];

      //Session name.
      $session_name = $_POST['session_name'];

      //Session Authentication Code.
      $session_auth = $_POST['session_auth'];

      //Start Date. Converted to Datetime Format.
      $start_date = $action->toDatetime( $_POST['start_time'] );

      //End Date. Converted to Date Format.
      $end_date = $action->toDatetime( $_POST['end_time'] );

      //Data Values.
      $data = [
        'session_name' => $session_name,
        'session_auth' => $session_auth,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'created' => date( 'Y-m-d H:i:s' )
      ];

      //Binds Values.
      $binds = [ '%s', '%s', '%s', '%s', '%s' ];

      //Update Session.
      $action->update_session( $id, $data, $binds );

      echo 'ok';
    break;

    //Delete Session Action.
    case 'delete_session':

      //Session ID.
      $id = (int)$_POST['id'];

      //Initiate AS_Action Class.
      $action = new Actions();

      //Delete Session.
      $action->session_delete( $id );
    break;

    //List of Pages.
    case 'page_list':
        ob_start();
        require_once( AS_PATH . 'includes/ajax_contents/page_list.php' );
        echo ob_get_clean();
    break;

    //List of Pages Mobile.
    case 'page_list_mobile':
      ob_start();
      require_once( AS_PATH . 'includes/ajax_contents/page_list_mobile.php' );
      echo ob_get_clean();
    break;

    //Add Page to Restrict.
    case 'add_page_restrict':

        //Value of Page to Restrict.
        $page = $_POST['page'];

        //Options from wp_options table.
        $current_pages = get_option( 'AS_Auth_Session' );

        //Decode JSON to Array.
        $current_pages = json_decode( $current_pages, true );

        //Array Values of Restrict Pages.
        $pages = $current_pages['as_options']['restrict_pages'];

        //if restrict_pages is empty and $page is not null.
        if ( empty( $pages ) && $page !== '' ) {

            //Add page slug to the restrict_pages.
            $current_pages['as_options']['restrict_pages'] = [ $page ];

            //Encode to JSON.
            $new_option = json_encode( $current_pages );

            //Update AS_Auth_Session Option.
            update_option( 'AS_Auth_Session', $new_option, 'yes' );

            echo 'ok';

        //If restrict_pages is not empty.
        } else if ( ! empty( $pages ) && $page !== '' ) {

            //If Page slug is not already in restrict_pages.
            if ( ! in_array( $page, $current_pages['as_options']['restrict_pages'] ) ) {

                //Merge Array. adding new Page Slug.
                $current_pages['as_options']['restrict_pages'] = array_merge( $current_pages['as_options']['restrict_pages'], [ $page ] );

                //Encode to JSON.
                $new_option = json_encode( $current_pages );

                //Update AS_Auth_Session Option.
                update_option( 'AS_Auth_Session', $new_option, 'yes' );

                echo 'ok';
            }
        }
    break;

    //Current List of Restricted Pages.
    case 'restricted_page_list':
        ob_start();
        require_once( AS_PATH . 'includes/ajax_contents/restrict_page_list.php' );
        echo ob_get_clean();
    break;

    //Remove Restrcted Page Action.
    case 'remove_restrict_page':

        //Value of Page from Restrict List.
        $page = $_POST['page'];

        //Options from wp_options table.
        $options = get_option( 'AS_Auth_Session' );

        //Decode JSON to Array.
        $current_pages = json_decode( $options, true );

        //Search Page Slug Key Number.
        $key = array_search( $page, $current_pages['as_options']['restrict_pages'] );

        //Unset/Remove Page Slug.
        unset( $current_pages['as_options']['restrict_pages'][$key] );

        //Encode to JSON.
        $new_option = json_encode( $current_pages );

        //Update AS_Auth_Session Option.
        update_option( 'AS_Auth_Session', $new_option, 'yes' );

        echo 'ok';
    break;

    //Page List for Login Redirect.
    case 'page_list_for_login_redirect':
        ob_start();
        require_once( AS_PATH . 'includes/ajax_contents/page_list_for_login.php' );
        echo ob_get_clean();
    break;

    //Page List for Login Redirect Mobile.
    case 'page_list_for_login_redirect_mobile':
      ob_start();
      require_once( AS_PATH . 'includes/ajax_contents/page_list_for_login_mobile.php' );
      echo ob_get_clean();
    break;

    //Set Login Redirect Page Action.
    case 'set_login_redirect':

        //Value of Page Selected.
        $page = $_POST['page'];

          //If page set.
        if ( $page ) {
            //Options from wp_options table.
            $options = get_option( 'AS_Auth_Session' );

            //Decode JSON to Array.
            $current_pages = json_decode( $options, true );

            //Set Login Redirect Page to Plugin's Options.
            $current_pages['as_options']['page_login_redirect'] = $page;

            //Encode to JSON.
            $new_option = json_encode( $current_pages );

            //Update AS_Auth_Session Option.
            update_option( 'AS_Auth_Session', $new_option, 'yes' );

            echo 'ok';
        }
    break;

    //Current Login Page Redirect.
    case 'current_page_redirect':
        ob_start();
        require_once( AS_PATH . 'includes/ajax_contents/current_login_page.php' );
        echo ob_get_clean();
    break;

    //Remove Login Page Redirect Action.
    case 'remove_login_page':

        //Options from wp_options table.
        $options = get_option( 'AS_Auth_Session' );

        //Decode JSON to Array.
        $current_pages = json_decode( $options, true );

        //Unset or null page_login_redirect.
        $current_pages['as_options']['page_login_redirect'] = null;

        //Encode to JSON.
        $new_option = json_encode( $current_pages );

        //Update AS_Auth_Session Option.
        update_option( 'AS_Auth_Session', $new_option, 'yes' );

        echo 'ok';
    break;

    //List of Pages for Logout Redirect.
    case 'page_list_for_logout_redirect':
      ob_start();
      require_once( AS_PATH . 'includes/ajax_contents/page_list_for_logout.php' );
      echo ob_get_clean();
    break;

    //List of Pages for Logout Redirect Mobile.
    case 'page_list_for_logout_redirect_mobile':
      ob_start();
      require_once( AS_PATH . 'includes/ajax_contents/page_list_for_logout_mobile.php' );
      echo ob_get_clean();
    break;


    //Set Logout Redirect Page Action.
    case 'set_logout_page':

        //Value of Page Selected.
        $page = $_POST['page'];

        //If Page set.
        if ( $page ) {

            //Options from wp_options table.
            $options = get_option( 'AS_Auth_Session' );

            //Decode JSON to Array.
            $current_pages = json_decode( $options, true );

            //Set Login Redirect Page to Plugin's Options.
            $current_pages['as_options']['page_logout_redirect'] = $page;

            //Encode to JSON.
            $new_option = json_encode( $current_pages );

            //Update AS_Auth_Session Option.
            update_option( 'AS_Auth_Session', $new_option, 'yes' );

            echo 'ok';
        }
    break;


    //Current Logout Page Redirect.
    case 'current_logout_page':
        ob_start();
        require_once( AS_PATH . 'includes/ajax_contents/current_logout_page.php' );
        echo ob_get_clean();
    break;


    //Remove Logout Page Redirect.
    case 'remove_logout_page':

        //Options from wp_options table.
        $options = get_option( 'AS_Auth_Session' );

        //Decode JSON to Array.
        $current_pages = json_decode( $options, true );

        //Unset or null page_login_redirect.
        $current_pages['as_options']['page_logout_redirect'] = null;

        //Encode to JSON.
        $new_option = json_encode( $current_pages );

        //Update AS_Auth_Session Option.
        update_option( 'AS_Auth_Session', $new_option, 'yes' );

        echo 'ok';
    break;

    //Check recaptcha if enabled or disabled.
    case 'recaptch_check_enable':

      //Plugin's Options.
      $options = get_option( 'AS_auth_session' );

      //Decode JSON to PHP Array.
      $options = json_decode( $options, true );

      //echo enabled value.
      if ( $options['as_options']['recaptcha']['enabled'] ) {
        echo 1;
      } else {
        echo 0;
      }
    break;

    //Recaptcha's Switch to enable or disable recaptcha.
    case 'recaptcha_switch':

      //$_POST enabled value.
      $enabled = $_POST['enabled'];

      //Plugin's options.
      $options = get_option( 'AS_auth_session' );

      //Decode JSON to PHP Array.
      $options = json_decode( $options, true );

      //Append enabled option.
      $options['as_options']['recaptcha']['enabled'] = $enabled;

      //Encode to JSON.
      $new_option = json_encode( $options );

      //Update Plugin's option.
      update_option( 'AS_Auth_Session', $new_option, 'yes' );
    break;

    //Get Recaptcha's Values from Plugin's options.
    case 'recaptcha_vals':

      //Plugin's option.
      $options = get_option( 'AS_Auth_Session' );

      //Decode JSON to PHP Array.
      $options = json_decode( $options, true );

      //Site key from option.
      $site_key = $options['as_options']['recaptcha']['site_key'];

      //Secret key from option.
      $secret_key = $options['as_options']['recaptcha']['secret_key'];

      //Validation Message from options.
      $validation = $options['as_options']['recaptcha']['validation'];

      //echo Values.
      echo $site_key . '||' . $secret_key . '||' . $validation ;
    break;

    //Save Recaptcha's settings.
    case 'recaptcha_save':

      //$_POST Site Key Value.
      $site_key = $_POST['site_key'];

      //$_POST Secret Key Value.
      $secret_key = $_POST['secret_key'];

      //$_POST Validation Message Value.
      $validation = $_POST['validation'];

      //Plugin's options.
      $options = get_option( 'AS_Auth_Session' );

      //Decode JSON to PHP Array.
      $options = json_decode( $options, true );

      //Append Site Key.
      $options['as_options']['recaptcha']['site_key'] = $site_key;

      //Append Secret Key.
      $options['as_options']['recaptcha']['secret_key'] = $secret_key;

      //Append Validation Message.
      $options['as_options']['recaptcha']['validation'] = $validation;

      //Encode to JSON.
      $new_option = json_encode( $options );

      //Update Plugin's option.
      update_option( 'AS_Auth_Session', $new_option, 'yes' );
    break;
  }

  wp_die();
}
