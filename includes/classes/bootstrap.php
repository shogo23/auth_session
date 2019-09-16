<?php

/*
* This is the main functionality of the plugin.
*/

namespace Shogo\SBV\Classes;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class Bootstrap {

  //Initiate Method.
  public function init() {

    //Initiate hooks.
    $this->hooks();

    //Check if user is not in admin panel.
    if ( ! $this->is_wp_panel() ) {

      //Initiate Action Class.
      $actions = new Actions();

      //Initiate Blocking Proccess.
      $actions->init();
    }
  }

  //Hook Method.
  public function hooks() {

    //Initiate Admin Enqueue Script.
    add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );

    //Initiate Admin Page.
    add_action( 'admin_menu', [ $this, 'create_admin_page' ] );

    //Initiate Ajax Hook.
    add_action( 'wp_ajax_sbv', 'sbv_ajax' );
  }

  //Enqueue Scripts Method.
  public function admin_enqueue_scripts() {

    global $pagenow;

    if ( ( $pagenow == 'admin.php' && $_GET['page'] == 'sbv_main_page' ) || ( $pagenow == 'admin.php' && $_GET['page'] == 'sbv_statistics' ) || ( $pagenow == 'admin.php' && $_GET['page'] == 'ip-blocked' ) || ( $pagenow == 'admin.php' && $_GET['page'] == 'clear-stats' ) ) {

      //Plugin's css style.
      wp_enqueue_style( 'SBV_style', plugins_url( '/shogo-block-visitor/css/style.css' ) );

      //Enqueue jQuery.
      wp_enqueue_script( 'jquery' );
    }
  }

  //Admin Page Method.
  public function create_admin_page() {

    //Main Page.
    add_menu_page(
      'Shogo\'s Block Visitor',
      'Shogo\'s Block Visitor',
      'manage_options',
      'sbv_main_page',
      [ $this, 'admin_page' ],
      'dashicons-format-aside'
    );

    //Statistics Page.
    add_submenu_page(
      'sbv_main_page',
      'Statistics',
      'Statistics',
      'manage_options',
      'sbv_statistics',
      [ $this, 'statistics_page' ]
    );
  }

  //Frontend Admin Page Method.
  public function admin_page() {
    ob_start();
    include_once( SBV . '/includes/pages/admin_page.php' );
    echo ob_get_clean();
  }

  //Frontend Statistics Page.
  public function statistics_page() {
    ob_start();
    include_once( SBV . '/includes/pages/statistics_page.php' );
    echo ob_get_clean();
  }

  //Get Options Method. Returns the values of plugin's options.
  public function get_ops() {

    return get_option( 'SBV_Option' );
  }

  //List Page Method. Returns list of pages.
  public function list_pages() {

    return get_pages();
  }

  //Update Options Method. Update plugin's options.
  public function update_ops( $new_vals ) {

    update_option( 'SBV_Option', $new_vals, 'yes' );
  }

  //Method to Check if country is already on the block lists.
  public function specific_country_exists( $country_code ) {

    //Plugin's Options.
    $bootstrap = $this->get_ops();

    //Deconde JSON to PHP Array.
    $bootstrap = json_decode( $bootstrap, true );

    //List of blocked countries form plugin's options.
    $countries = $bootstrap['sbv_options']['ban_some']['banned']['country'];

    //Loop to check if country is already in the block list. Return Boolean.
    foreach ( $countries as $c ) {
      foreach ( $c as $c_code => $name ) {
        if ( $country_code == $c_code  ) {
          return true;
        }
      }
    }
  }

  //Method to Check if country is already on the excemption lists.
  public function block_all_country_exists( $country_code ) {
    //Plugin's Options.
    $bootstrap = $this->get_ops();

    //Deconde JSON to PHP Array.
    $bootstrap = json_decode( $bootstrap, true );

    //List of blocked countries form plugin's options.
    $countries = $bootstrap['sbv_options']['ban_all']['exception']['country'];

    //Loop to check if country is already in the block list. Return Boolean.
    foreach ( $countries as $c ) {
      foreach ( $c as $c_code => $name ) {
        if ( $country_code == $c_code  ) {
          return true;
        }
      }
    }
  }

  //Method to get the countries block list. Return array().
  public function specific_current_country_list() {

    //Plugin's Options.
    $bootstrap = $this->get_ops();

    //Decode JSON to PHP Array.
    $bootstrap = json_decode( $bootstrap, true );

    //List of Countries.
    $countries = $bootstrap['sbv_options']['ban_some']['banned']['country'];

    return $countries;
  }

  //Method to check if IP Address is already in the block list.
  public function specific_ip_exists( $ip ) {

    //Plugin's Options.
    $bootstrap = $this->get_ops();

    //Decode JSON to PHP Array.
    $options = json_decode( $bootstrap, true );

    //Check if IP Address is already in the block list. Return Boolean.
    if ( in_array( $ip, $options['sbv_options']['ban_some']['banned']['ip'] ) ) {
      return true;
    }

    return false;
  }

  //Method to check if IP Address is already in the excemption list.
  public function excemption_ip_exists( $ip ) {

    //Plugin's Options.
    $bootstrap = $this->get_ops();

    //Decode JSON to PHP Array.
    $options = json_decode( $bootstrap, true );

    //Check if IP Address is already in the excemption list. Return Boolean.
    if ( in_array( $ip, $options['sbv_options']['ban_all']['exception']['ip'] ) ) {
      return true;
    }

    return false;
  }

  //List of Current Countries Exception.
  public function exception_countries_list_current() {

    //Plugin's Options.
    $bootstrap = $this->get_ops();

    //Decode JSON to PHP Array.
    $options = json_decode( $bootstrap, true );

    return $options['sbv_options']['ban_all']['exception']['country'];
  }
  
  //Method to get user's country code.
  public function users_cc() {

    //Initiate UsersInfo Class.
    $usersinfo = new UsersInfo();

    //Return Country Code.
    return $usersinfo->country_code;
  }

  //Method to get user's IP Address.
  public function users_ip() {

    //Initiate UsersInfo Class.
    $usersinfo = new UsersInfo();

    //Return IP Address.
    return $usersinfo->ip;
  }

  //Method to get user's Hostname.
  public function users_hostname() {

    //Initiate UsersInfo Class.
    $usersinfo = new UsersInfo();

    //Return Hostname.
    return $usersinfo->hostname;
  }

  //Method to get user's City.
  public function users_city() {

    //Initiate UsersInfo Class.
    $usersinfo = new UsersInfo();

    //Return Hostname.
    return $usersinfo->city;
  }

  //Method to get user's Region.
  public function users_region() {

    //Initiate UsersInfo Class.
    $usersinfo = new UsersInfo();

    //Return Hostname.
    return $usersinfo->region;
  }

  //Method to get user's Location.
  public function users_loc() {

    //Initiate UsersInfo Class.
    $usersinfo = new UsersInfo();

    //Return Hostname.
    return $usersinfo->loc;
  }

  //Method to get user's ISP Provider.
  public function users_org() {

    //Initiate UsersInfo Class.
    $usersinfo = new UsersInfo();

    //Return Hostname.
    return $usersinfo->org;
  }

  //Reorder Country and IP Address List after delete. Return new value.
  public function reorder( $lists ) {

    //Increment starter.
    $i = 0;

    //New List order container
    $new_lists;

    //Loop to create new list with ordered position number.
    foreach ( $lists as $list ) {

      //Create New List.
      $new_lists[$i] = $list;

      //Increment.
      $i++;
    }

    //Return new ordered list.
    return $new_lists;
  }

  /*
  * Method to check if user is in admin panel.
  * And to prevent conflict for accessing admin panel.
  */
  private function is_wp_panel() {

    //Global WP Pagenow.
    global $pagenow;

    //Site URI
    $uri = $_SERVER['REQUEST_URI'];

    //Explode and get uri only.
    $uri = explode( '/', $uri );

    //If uri and page now are matched.
    if ( $uri[1] == 'wp-admin' || $pagenow == 'wp-login.php' || $uri[1] == 'admin' ) {

      //Return Boolean.
      return true;
    }

    return false;
  }

  //Method to Clear Statistics.
  public function clear_stats() {

    //Initiate Stats Class.
    $stats = new Stats();

    //Execute clear stats.
    $stats->clear_stats();
  }
}
