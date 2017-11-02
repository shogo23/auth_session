<?php

/*
* Plugin Name: Auth Session
* Description: Made by gervic.
* Author: Victor Caviteno
* Author URI : http://www.facebook.com/gervic23
*/

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

//Plugin Location Path.
define( 'AS_PATH', plugin_dir_path( __FILE__ ) );

/***************
* Include Files
****************/
//Include install.php
require_once( AS_PATH . 'install.php' );

//Include uninstall.php
require_once( AS_PATH . 'uninstall.php' );

//Include Interface.
require_once( AS_PATH . 'interface/main_interface.php' );

//Include Core Class File.
require_once( AS_PATH . 'classes/core.php' );

//Include Widget Class File.
require AS_PATH . 'classes/widget.php';

//Include Bootstrap Class File.
require_once( AS_PATH . 'classes/bootstrap.php' );

//Include Action Class File.
require_once( AS_PATH . 'classes/actions.php' );

//Include Form Class.
require_once( AS_PATH . 'classes/form.php' );

//Include Session Class.
require_once( AS_PATH . 'classes/session.php' );

//Include Helper Class.
require_once( AS_PATH . 'classes/helper.php' );

//Include Ajax Action File.
require_once( AS_PATH . 'includes/ajax.php' );

//Include Shortcodes Class.
require_once( AS_PATH . 'classes/shortcodes.php' );

//Include Recaptcha Class.
require_once( AS_PATH . 'classes/recaptcha.php' );

//Initiate Activation Hook to install database table.
register_activation_hook( __FILE__, 'Shogo_AS_install' );

//Initiate Deactivation Hook to install database table.
register_deactivation_hook( __FILE__, 'Shogo_AS_uninstall' );

//Import Bootstrap Class.
use Shogo\Auth_Session\Classes\Bootstrap;

//Import Actions Class.
use Shogo\Auth_Session\Classes\Actions;

//Import Class Auth_Session.
use Shogo\Auth_Session\Classes\Auth_Session;

//Initiate Bootstrap Class.
$bootstrap = new Bootstrap();

//Initiate Plugin's Bootstrap.
$bootstrap->initiate();

//Initiate Page Restricting.
$action = new Actions();

//Initiate Helper Class.
$auth_session = new Auth_Session();
