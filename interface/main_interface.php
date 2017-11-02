<?php

namespace Shogo\Auth_Session\Classes;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

interface AS_Main {

  public function initiate();

  public function hooks();

  public function timezone();

  public function session();

  public function admin_enqueque_scripts();

  public function admin_menu();

  public function admin_main_page();

  public function create_auth();

  public function settings_page();

  public function user_check();

  public function datetime_format( $date );

  public function sess_count();

  public function session_results();

  public function one_session( $id );

  public function insertToDB( $data, $binds = false );

  public function session_update( $id, $data, $binds = false );

  public function session_delete( $id );

  public function datestr( $datetime );

  public function sess_status( $start_date, $end_date );

  public function ch_option();

  public function get_pages();

  public function user_session_details();

  public function logout();
}
