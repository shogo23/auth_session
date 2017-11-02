<?php

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

//Database Table Installation Action.
function Shogo_AS_install() {
  global $wpdb;

  //Table name.
  $table = $wpdb->prefix . 'shogo_sa_sessions';

  //Charset Coallate.
  $charset_collate = $wpdb->get_charset_collate();

  //Sql Command Creating Table.
  $sql = "CREATE TABLE $table (
    id bigint(100) NOT NULL AUTO_INCREMENT,
    session_name varchar(255) DEFAULT '' NOT NULL,
    session_auth varchar(255) DEFAULT '' NOT NULL,
    start_date datetime DEFAULT '0000-00-00' NOT NULL,
    end_date datetime DEFAULT '0000-00-00' NOT NULL,
    created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
    UNIQUE KEY id (id)
  ) $charset_collate;";

  require_once( ABSPATH.'wp-admin/includes/upgrade.php' );

  dbDelta( $sql );

  //Database Table Version.
  add_option( 'AUTH_SESSION', '1.0' );

  //Create pages for Login.
  $login_page = [
    'post_author' => 'Gervic Caviteno',
    'post_title' => 'Session Login',
    'post_name' => 'sa-session-login',
    'post_type' => 'page',
    'post_status' => 'publish',
    'post_content' => '[as_auth_session page="login"]'
  ];

  //Create Logout Page.
  $logout_page = [
    'post_author' => 'Gervic Caviteno',
    'post_title' => 'Session Logout',
    'post_name' => 'sa-session-logout',
    'post_type' => 'page',
    'post_status' => 'publish',
    'post_content' => '[as_auth_session page="logout"]'
  ];

  wp_insert_post( $login_page );
  wp_insert_post( $logout_page );

  //Create WP Option for this plugin.
  $options['as_options'] = [
    'restrict_pages' => [],
    'page_login_redirect' => null,
    'page_logout_redirect' => null,
    'recaptcha' => [
      'enabled' => 0,
      'site_key' => null,
      'secret_key' => null,
      'validation' => 'Please verify that you are a human.'
    ]
  ];

  //Encode to JSON.
  $options = json_encode( $options );

  //Add Option for this plugin.
  add_option( 'AS_Auth_Session', $options, '', 'yes' );
}
