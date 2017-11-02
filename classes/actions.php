<?php

namespace Shogo\Auth_Session\Classes;

//Import Bootstrap Class.
use Shogo\Auth_Session\Classes\Bootstrap;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class Actions {

  //Datetime String Converter Action.
  public function toDatetime( $date ) {

    //Initiate Bootstrap Class.
    $bootstrap = new Bootstrap();

    return $bootstrap->datetime_format( $date );
  }

  //Converts Datetime to String.
  public function datetimeToStr( $datetime ) {

    //Initiate Bootstrap Class.
    $bootstrap = new Bootstrap();

    return $bootstrap->datestr( $datetime );
  }

  //Fetch Session Status.
  public function session_status( $start_date, $end_date ) {

    //Initiate Bootstrap Class.
    $bootstrap = new Bootstrap();

    return $bootstrap->sess_status( $start_date, $end_date );
  }

  //Count Session Results.
  public function session_count() {

    //Initiate Bootstrap Class.
    $bootstrap = new Bootstrap();

    return $bootstrap->sess_count();
  }

  //Fetch Session Results Action.
  public function session_results() {

    //Initiate Bootstrap Class.
    $bootstrap = new Bootstrap();

    return $bootstrap->session_results();
  }

  //Insert to Database Action.
  public function insert_to_db( $data, $binds = false ) {

    //Initiate Bootstrap Class.
    $bootstrap = new Bootstrap();

    $bootstrap->insertToDB( $data, $binds );
  }

  //Check if nessesary settings are set.
  public function as_option() {

    $bootstrap = new Bootstrap();

    return $bootstrap->ch_option();
  }

  //Get Pages.
  public function get_pages() {

    $bootstrap = new Bootstrap();

    return $bootstrap->get_pages();
  }

  //Get Specific Session.
  public function get_session( $id ) {
    $bootstrap = new Bootstrap();

    return $bootstrap->one_session( $id );
  }

  public function update_session( $id, $data, $binds = false ) {
    $bootstrap = new Bootstrap();

    $bootstrap->session_update( $id, $data, $binds );
  }

  public function session_delete( $id ) {
    $bootstrap = new Bootstrap();

    $bootstrap->session_delete( $id );
  }

  //Check User for Privillage Access.
  public function check_user() {
    $bootstrap = new Bootstrap();

    $bootstrap->user_check();
  }

  //Get User's Session Details.
  public function session_details() {
    $bootstrap = new Bootstrap();

    return $bootstrap->user_session_details();
  }

  //Logout Action.
  public function logout() {
    $bootstrap = new Bootstrap();

    $bootstrap->logout();
  }
}
