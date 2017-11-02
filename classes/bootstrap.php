<?php

namespace Shogo\Auth_Session\Classes;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class Bootstrap extends Core implements AS_Main {

  //Table Name Property.
  public static $table_name;

  //Validation Error Message Global.
  public static $validation_error;

  public function initiate() {

    //Load Hooks.
    $this->hooks();

    //Load Session.
    $this->session();

    //Set Table Name.
    $this->table_name();

    //Set Timezone.
    $this->timezone();
  }

  public function hooks() {

    //Enqueque Scripts For Admin Page.
    add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueque_scripts' ] );

    //Enqueue Scripts on Front End.
    add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

    //Admin Pages.
    add_action( 'admin_menu', [ $this, 'admin_menu' ] );

    //Initiate ajax hook.
    add_action( 'wp_ajax_AS_auth_session', 'Shogo_AS_ajax' );

    //Initiate Shortcodes for Login and Logout.
    add_shortcode( 'as_auth_session', [ 'AS_Shortcodes', 'shortcode' ] );

    //Initiate Shortcodes for Welcome Session Name.
    add_shortcode( 'as_auth_session_welcome', [ 'AS_Shortcodes', 'welcome' ] );

    //Initiate Shortcodes for Logout HyperText.
    add_shortcode( 'as_auth_session_logout', [ 'AS_Shortcodes', 'logout' ] );

    //Initiate User Check Privillage.
    add_action( 'template_redirect', [ $this, 'user_check' ] );

    //Initiate Post Request Action.
    add_action( 'init', [ $this, 'post_request' ] );

    //Initiate Widget.
    add_action( 'widgets_init', create_function( '', 'return register_widget( "AS_Widget" );') );
  }

  //Table Name Action.
  public function table_name() {

    global $wpdb;

    //Set Table Name Property.
    self::$table_name = $wpdb->prefix . 'shogo_sa_sessions';
  }

  //Timezone Action.
  public function timezone() {
    date_default_timezone_set( get_option( 'timezone_string' ) );
  }

  //Session Enable.
  public function session() {
    if ( ! session_id() ) {
      session_start();
    }
  }

  public function enqueue_scripts() {
    wp_enqueue_style( 'AS_Style', plugins_url( '/auth_session/css/style.css' ) );
    wp_enqueue_script( 'AS_Recaptcha', 'https://www.google.com/recaptcha/api.js', '', '', true );
  }

  //Include js and css scripts.
  public function admin_enqueque_scripts() {
    global $pagenow, $typenow;

    if ( $pagenow == 'admin.php' && ( $_GET['page'] == 'as_main_page' || $_GET['page'] == 'as_create_auth' || $_GET['page'] == 'as_settings' ) ) {
      wp_enqueue_script( 'jquery' );
      wp_enqueue_style( 'AS_Admin_Style', plugins_url( '/auth_session/css/admin.css' ) );
      wp_enqueue_style( 'jquery-ui.min-date-picker', plugins_url( '/auth_session/css/jquery-ui.min.css' ) );
      wp_enqueue_script( 'jquery-ui-datepicker' );
    }
  }

  //Admin Menu Page.
  public function admin_menu() {

    //Main Page.
    add_menu_page(
      'Auth Session',
      'Auth Session',
      'manage_options',
      'as_main_page',
      [ $this, 'admin_main_page' ],
      'dashicons-format-aside'
    );

    add_submenu_page(
        'as_main_page',
        'Create Auth Session',
        'Create Auth Session',
        'manage_options',
        'as_create_auth',
        [ $this, 'create_auth' ]
    );

    add_submenu_page(
      'as_main_page',
      'Settings',
      'Settings',
      'manage_options',
      'as_settings',
      [ $this, 'settings_page' ]
    );
  }

  //Main Page Action.
  public function admin_main_page() {
    ob_start();

    echo $pagenow;
    require_once( AS_PATH . 'includes/pages/main.php' );
    echo ob_get_clean();
  }

  //Create Auth Session Page Action.
  public function create_auth() {
    ob_start();
    require_once( AS_PATH . 'includes/pages/create_auth.php' );
    echo ob_get_clean();
  }

  //Settings Page Action
  public function settings_page() {
    ob_start();
    require_once( AS_PATH . 'includes/pages/settings.php' );
    echo ob_get_clean();
  }

  //Check User for Privillage Access.
  public function user_check() {

    //Get Query Object.
    $page_object = get_queried_object();

    //Current Post Name.
    $post_name = $page_object->post_name;

    //Plugin Options.
    $options = get_option( 'AS_Auth_Session' );

    //Decode JSON to Array.
    $opt_pages = json_decode( $options, true );

    //If User has no Session and Current Page is restricted.
    if ( ! $this->has_session() && in_array( $post_name, $opt_pages['as_options']['restrict_pages'] ) ) {

      //Url Redirect Val.
      $url = get_site_url() . '/sa-session-login/?redirect=' . $post_name;

      //Redirect User to Login Page.
      wp_redirect( $url );

      exit;

    //If User has Session and Check if User was in restricted pages.
    } else if ( in_array( $post_name, $opt_pages['as_options']['restrict_pages'] ) ) {

      //User's Session Details.
      $auth = $this->session_details();

      //User's Authentication Code.
      $auth = $auth['session_auth'];

      //Verify Session Authentication Code if not Active.
      if ( $this->veify_auth( $auth ) !== 'active' ) {

        //Destroy User's Session.
        $this->session_destroy();

        //URL to Login Page.
        $url = get_site_url() . '/sa-session-login/?redirect=' . $post_name;

        //Redirect to Login Page.
        wp_redirect( $url );

        exit;
      }
    }
  }

  //Post Request Action.
  public function post_request() {

    if ( $_POST && $_POST['as_auth_login'] && wp_verify_nonce( $_POST['as_csrf'], 'as_nonce' ) ) {

      //If Authentication is null or not.
      if ( $_POST['as_auth'] == '' ) {
        self::$validation_error = 'empty';

      } else {

        //If Authentication code not found in database.
        if ( $this->check_auth_code( $_POST['as_auth'] ) <= 0 ) {

          //Global Validation Error.
          self::$validation_error = 'invalid';

          //If Authentication code is Inactive.
        } else if ( $this->veify_auth( $_POST['as_auth'] ) == 'inactive' ) {

          //Global Validation Error.
          self::$validation_error = $this->veify_auth( $_POST['as_auth'] );

          //If Authentication code is Expired.
        } else if ( $this->veify_auth( $_POST['as_auth'] ) == 'expired' ) {

          //Global Validation Error.
          self::$validation_error = $this->veify_auth( $_POST['as_auth'] );

          //If Authentication code is Active.
        } else if ( $this->veify_auth( $_POST['as_auth'] ) == 'active' ) {

          //Initiate Recaptcha Class.
          $recaptcha = new Recaptcha();

          //If Recaptcha is enabled.
          if ( $recaptcha->enabled ) {

            //Validate Recaptcha.
            if ( $recaptcha->validation() ) {

              //Redirect User.
              $this->redirectUser();
            } else {

              //Redirect User.
              self::$validation_error = 'recaptcha_error';
            }

          } else {

            //Redirect User.
            $this->redirectUser();
          }
        }
      }
    }
  }

  private function redirectUser() {

    //AS Options from wp_options Table.
    $options = get_option( 'AS_Auth_Session' );

    //Decode JSON to Array.
    $opt_pages = json_decode( $options, true );

    //If $_GET['redirect'] isset.
    if ( $_GET['redirect'] ) {

      //Page Value.
      $page = $_GET['redirect'];
    } else {

      //Page Value.
      $page = $opt_pages['as_options']['page_login_redirect'];
    }

    //Set User a Session.
    $this->access_granted( $_POST['as_auth'] );

    //Redirect to restricted page.
    wp_redirect( get_site_url() . '/' . $page );
    exit;
  }

  public function login_check() {
    return $this->has_session();
  }

  //Destroy User's Session.
  public function sess_destroy() {
    $this->session_destroy();
  }

  //Datetime String Converter Action.
  public function datetime_format( $date ) {
    return $this->datetime( $date );
  }

  //Count Session Results.
  public function sess_count() {
    return $this->session_count();
  }

  //Fetch Session Results Action.
  public function session_results() {
    return $this->sessions();
  }

  //Get Specific Session.
  public function one_session( $id ) {
    return $this->get_session( $id );
  }

  //Insert to Database Action.
  public function insertToDB( $data, $binds = false  ) {
    $this->insert_data( $data, $binds );
  }

  //Update Session.
  public function session_update( $id, $data, $binds = false ) {
    $this->update_session( $id, $data, $binds );
  }

  //Delete Session.
  public function session_delete( $id ) {
    $this->delete_session( $id );
  }

  //Converts Datetime to String.
  public function datestr( $datetime ) {
    return $this->datetime_to_str( $datetime );
  }

  //Fetch Session Status.
  public function sess_status( $start_date, $end_date ) {
    return $this->session_status( $start_date, $end_date );
  }

  //Check if nessesary settings are set.
  public function ch_option() {
    return $this->check_settings();
  }

  //Get Pages.
  public function get_pages() {
    return $this->pages();
  }

  //Get User's Session Details.
  public function user_session_details() {
    return $this->session_details();
  }

  //Logout Action.
  public function logout() {

    //AS_Auth_Session Option from wp_option.
    $options = get_option( 'AS_Auth_Session' );

    //Decode JSON to Array.
    $options = json_decode( $options, true );

    //Logout Redirect Page.
    $logout_redirect = $options['as_options']['page_logout_redirect'];

    //Set Url Redirect.
    $url = get_site_url() . '/' . $logout_redirect;

    //Destroy User's Session.
    $this->session_destroy();

    //Redirect to Logout Redirect Page.
    echo '<script>location = "'. $url .'";</script>';
  }
}
