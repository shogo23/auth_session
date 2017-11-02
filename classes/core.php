<?php

namespace Shogo\Auth_Session\Classes;

//Import Bootstrap Class.
use Shogo\Auth_Session\Classes\Bootstrap;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

abstract class Core {

  private $as_option_bool = false;

  //Count Session Results.
  protected function session_count() {

    global $wpdb;

    return intVal( $wpdb->get_var( "SELECT COUNT(*) FROM " . Bootstrap::$table_name ) );
  }

  //Fetch Session Results Action.
  protected function sessions() {

    global $wpdb;

    return $wpdb->get_results( "SELECT * FROM " . Bootstrap::$table_name . " ORDER BY id DESC" );
  }

  //Get Specific Session.
  protected function get_session( $id ) {

    global $wpdb;

    return $wpdb->get_results( "SELECT * FROM " . Bootstrap::$table_name . " WHERE id = '$id' ORDER BY id DESC" );
  }

  //Insert To Database Action.
  protected function insert_data( $data , $binds = false ) {

    global $wpdb;

    //If has binds.
    if ( $binds ) {
      $wpdb->insert( Bootstrap::$table_name, $data, $binds );
    } else {
      $wpdb->insert( Bootstrap::$table_name, $data );
    }
  }

  //Update Session.
  protected function update_session( $id, $data, $binds = false ) {

    global $wpdb;

    //Where ID.
    $id = ['id' => $id];

    //If has binds.
    if ( $binds ) {
      $wpdb->update( Bootstrap::$table_name, $data, $id, $binds, ['%d'] );
    } else {
      $wpdb->update( Bootstrap::$table_name, $data, $id );
    }
  }

  //Delete Session.
  protected function delete_session( $id ) {

    global $wpdb;

    //Where ID.
    $id = ['id' => $id];

    $wpdb->delete( Bootstrap::$table_name, $id );
  }

  //Fetch Session Status.
  protected function session_status( $start_date, $end_date ) {

    //Current Date.
    $current_date = date( 'Y-m-d H:i:s' );

    //If Status is Inactive.
    if ( $start_date > $current_date ) {
      return '<span style="color: red;">Inactive</span>';

    //If Status is Active.
    } else if ( $start_date < $current_date && $end_date > $current_date ) {
      return '<span style="color: green;">Active</span>';

    //If Status is Expired.
    } else if ( $end_date < $current_date ) {
      return '<span style="color: red;">Expired</span>';
    }
  }

  //Datetime String Converter Action.
  protected function datetime( $date ) {

    //Explode Date via spaces.
    $date_array = explode( ' ', $date );

    //Date Month.
    $month = $date_array[0];

    //Date Day. Chop/Remove coma in the string.
    $day = chop( $date_array[1], ',' );

    //Date Year.
    $year = $date_array[2];

    //Convert Month to number.
    switch ( $month ) {
      case 'January':
        $month = '01';
      break;

      case 'February':
        $month = '02';
      break;

      case 'March':
        $month = '03';
      break;

      case 'April':
        $month = '04';
      break;

      case 'May':
        $month = '05';
      break;

      case 'June':
        $month = '06';
      break;

      case 'July':
        $month = '07';
      break;

      case 'August':
        $month = '08';
      break;

      case 'September':
        $month = '09';
      break;

      case 'October':
        $month = '10';
      break;

      case 'November':
        $month = '11';
      break;

      case 'December':
        $month = '12';
      break;
    }

    return $year . '-' . $month . '-'. $day . ' 00:00:00';
  }

  //Converts Datetime to String.
  protected function datetime_to_str( $datetime ) {

    //Remove 00:00:00 from Datetime.
    $date = substr( $datetime, 0, 10 );

    //Explode Datetime via dash.
    $date_array = explode( '-', $date );

    //Date Year.
    $year = $date_array[0];

    //Date Month.
    $month = $date_array[1];

    //Date Day.
    $day = $date_array[2];

    //Convert Numeric Months to Month Name.
    switch ( $month ) {
      case '01':
        $month = 'January';
      break;

      case '02':
        $month = 'Februrary';
      break;

      case '03':
        $month = 'March';
      break;

      case '04':
        $month = 'April';
      break;

      case '05':
        $month = 'May';
      break;

      case '06':
        $month = 'June';
      break;

      case '07':
        $month = 'July';
      break;

      case '08':
        $month = 'August';
      break;

      case '09':
        $month = 'September';
      break;

      case '10':
        $month = 'October';
      break;

      case '11':
        $month = 'November';
      break;

      case '12':
        $month = 'December';
      break;
    }

    return $month . ' ' . $day . ', '. $year;
  }

  //Check if nessesary settings are set.
  protected function check_settings() {

    //Plugin Option.
    $option = get_option( 'AS_Auth_Session' );

    //Decode JSON to Array.
    $option = json_decode( $option, true );

    //Error Array Container.
    $errors = [];

    //If no Restricted Pages.
    if ( $option['as_options']['restrict_pages'] == null ) {
      $errors[] = 'You don\'t have restricted pages. Go to settings to set.';
    }

    //If no Page Login Redirect.
    if ( $option['as_options']['page_login_redirect'] == null ) {
      $errors[] = 'Your don\'t have session login redirect page. Go to settings to set.';
    }

    //If no Page Logout Redirect.
    if ( $option['as_options']['page_logout_redirect'] == null ) {
      $errors[] = 'Your don\'t have session logout redirect page. Go to settings to set.';
    }

    //If has Errors.
    if ( !empty( $errors ) ) {

      $error = '';

      foreach ( $errors as $e ) {
        $error .= '<p class="error">' . $e . '</p>';
      }

      return $error;
    }

    return null;
  }

  //Get Pages.
  protected function pages() {

    $args = [
      'sort_order' => 'asc',
    	'sort_column' => 'post_title',
    	'hierarchical' => 1,
    	'exclude' => '',
    	'include' => '',
    	'meta_key' => '',
    	'meta_value' => '',
    	'authors' => '',
    	'child_of' => 0,
    	'parent' => -1,
    	'exclude_tree' => '',
    	'number' => '',
    	'offset' => 0,
    	'post_type' => 'page',
    	'post_status' => 'publish'
    ];

    return get_pages( $args );
  }

  //Check if User has Session Action.
  protected function has_session() {

    if ( $_SESSION['Auth_Session']['AS_is_logged_in'] ) {
      return true;
    }

    return false;
  }

  //Check Authentication Code Action.
  protected function check_auth_code( $auth ) {

    global $wpdb;

    $query = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM " . Bootstrap::$table_name . " WHERE session_auth = %s", $auth ) );

    //Count Results.
    $count = count( $query );

    return $count;
  }

  //Verify Authentication Code.
  protected function veify_auth( $auth ) {

    global $wpdb;

    $query = $wpdb->get_results( $wpdb->prepare( "SELECT start_date, end_date FROM " . Bootstrap::$table_name . " WHERE session_auth = %s", $auth ) );

    //Start Date.
    $start_date = $query[0]->start_date;

    //End Date.
    $end_date = $query[0]->end_date;

    //Current Date.
    $current_date = date( 'Y-m-d H:i:s' );

    //If Auth Code is Inactive
    if ( $start_date > $current_date ) {
      return 'inactive';

    //If Auth Code is Active.
    } else if ( $start_date < $current_date && $end_date > $current_date ) {
      return 'active';

    //If Auth Code is Expired.
    } else if ( $end_date < $current_date ) {
      return 'expired';
    }
  }

  //Set User a $_SESSION.
  protected function access_granted( $auth ) {

    global $wpdb;

    $query = $wpdb->get_results( $wpdb->prepare( "SELECT session_name, session_auth FROM " . Bootstrap::$table_name . " WHERE session_auth = %s", $auth ) );

    //Authentication Session Name.
    $session_name = $query[0]->session_name;

    //Authentication Code.
    $session_auth = $query[0]->session_auth;

    //Session Data.
    $data = [ 'AS_is_logged_in' => 1, 'session_name' => $session_name, 'session_auth' => $session_auth ];

    //Set Session.
    $_SESSION['Auth_Session'] = $data;
  }

  //User Session Details.
  protected function session_details() {
    if ( $_SESSION['Auth_Session'] ) {
      return $_SESSION['Auth_Session'];
    }

    return null;
  }

  //Destroy User Session.
  protected function session_destroy() {
    unset( $_SESSION['Auth_Session'] );
  }
}
