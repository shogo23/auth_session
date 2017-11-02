<?php

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

//Uninstall Action.
function Shogo_AS_uninstall() {
  global $wpdb;

  //Table name.
  $table = $wpdb->prefix . 'shogo_sa_sessions';

  //Drop Database Table.
  $wpdb->query( "DROP TABLE " . $table );

  //Delete Plugin's Option from wp_options Table.
  delete_option( 'AS_Auth_Session' );

  $args = [
    'post_type'               => 'page',
    'orderby'                 => 'menu_order',
    'order'                   => 'ASC',
    'no_found_rows'           => true,
    'update_post_term_cache'  => false
  ];

  //WP_Query Instance.
  $query = new WP_Query( $args );

  //Get Pages.
  $posts = $query->get_posts();

  //ID Container Val.
  $login_page_id = '';

  //ID Container Val.
  $logout_page_id = '';

  //Loop all pages to get page id of postname sa-session-login and sa-session-logout.
  foreach ( $posts as $post ) {

    //Get ID of sa-session-login.
    if ( $post->post_name == 'sa-session-login' ) {

      //Append val.
      $login_page_id .= $post->ID;
    }

    //Get ID of sa-session-logout.
    if ( $post->post_name == 'sa-session-logout' ) {

      //Append val.
      $logout_page_id .= $post->ID;
    }
  }

  //Delete sa-session-login and sa-session-logout Page.
  wp_delete_post( $login_page_id );
  wp_delete_post( $logout_page_id );
}
