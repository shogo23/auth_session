<?php

/*
* This Class execute the blocking functionality.
*/

namespace Shogo\SBV\Classes;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class Actions {

  /*
  * Plugin's Options Property.
  */
  private $options;

  /*
  * Users IP Address value.
  */
  private $ip;

  /*
  * Country code value.
  */
  private $country_code;

  /*
  * Hostname Value.
  */
  private $hostname;

  /*
  * City Value.
  */
  private $city;

  /*
  * Region Value.
  */
  private $region;

  /*
  * Location Value.
  */
  private $loc;

  /*
  * ISP Provider Value.
  */
  private $org;

  /*
  * Method to Initiate Blocking Functionality.
  */
  public function init() {

    //Initiate Bootstrap Class.
    $bootstrap = new Bootstrap();

    //Plugin's Options.
    $options = $bootstrap->get_ops();

    //Decode JSON to PHP Array.
    $options = json_decode( $options, true );

    //Global Plugin Options.
    $this->options = $options;

    //Global Country Code.
    $this->country_code = $bootstrap->users_cc();

    //Global IP Address.
    $this->ip = $bootstrap->users_ip();

    //Global Hostname.
    $this->hostname = $bootstrap->users_hostname();

    //Global City.
    $this->city = $bootstrap->users_city();

    //Global Region.
    $this->region = $bootstrap->users_region();

    //Global Location.
    $this->loc = $bootstrap->users_loc();

    //Global ISP Provider.
    $this->org = $bootstrap->users_org();

    //Check if has Redirect Page.
    if ( $this->has_redirect_page() ) {

      //Check if user is not in blocked page.
      if ( ! $this->is_blocked_page() ) {

        /*
        * Check if specific block is enabled.
        * If Enabled, this will be the main blocking functionality.
        */
        if ( $this->is_specific() ) {

          //Initiate Specific Blocking.
          $this->do_specific_block();
        }

        /*
        * Check if Block All is Enabled.
        * If Enabled, this will be the main blocking functionality.
        */
        if ( $this->is_block_all() ) {

          //Initiate Block All.
          $this->do_block_all();
        }
      }
    }
  }

  /*
  * Check if User is in blocked page.
  * And to prevent too many page redirects.
  */
  private function is_blocked_page() {

    //Site URI
    $uri = $_SERVER['REQUEST_URI'];

    //Explode and get uri only.
    $uri = explode( '/', $uri );

    //If uri and page now are matched.
    if ( $uri[1] == $this->page_redirect_uri() ) {

      //Return Boolean.
      return true;
    }

    return false;
  }

  /*
  * Method to Check if Specific Block is enabled.
  */
  private function is_specific() {

    //Initiate Bootstrap Class.
    $bootstrap = new Bootstrap();

    //Plugin's Options.
    $options = $bootstrap->get_ops();

    //Decode JSON to PHP Array.
    $options = json_decode( $options, true );

    //Check if specific block option is enabled or not.
    if ( $options['sbv_options']['ban_some']['enabled'] ) {

      //Return Boolean.
      return true;
    }

    return false;
  }

  /*
  * Method to Check Block All Option is Enabled.
  */
  private function is_block_all() {

    //Initiate Bootstrap Class.
    $bootstrap = new Bootstrap();

    //Plugin's Options.
    $options = $bootstrap->get_ops();

    //Decode JSON to PHP Array.
    $options = json_decode( $options, true );

    //Check if block all option is enabled or not.
    if ( $options['sbv_options']['ban_all']['enabled'] ) {

      //Return Boolean.
      return true;
    }

    return false;
  }

  /*
  * Method to check if page redirect is set.
  */
  private function has_redirect_page() {

    //Initiate Bootstrap Class.
    $bootstrap = new Bootstrap();

    //Plugin's Options.
    $options = $bootstrap->get_ops();

    //Decode JSON to PHP Array.
    $options = json_decode( $options, true );

    //Check if redirect page is set.
    if ( ! empty( $options['sbv_options']['page_redirect'] ) ) {

      //Return Boolean.
      return true;
    }

    return false;
  }

  /*
  * Method to redirect user to the block page.
  */
  private function redirect() {

    //The Plugin's Options.
    $options = $this->options;

    //Page Redirect.
    $page = $options['sbv_options']['page_redirect'];

    //Post Name Container.
    $p_name = '';

    foreach ( $page as $post_name => $post_title ) {
      $p_name .= $post_name;
    }

    //Redirect Block user.
    header('Location:  ' . get_site_url(). '/' . $post_name . '/' );
    exit;
  }

  /*
  * Method to proccess Specific Block.
  */
  private function do_specific_block() {

    //The Plugin's Options.
    $options = $this->options;

    /*
    * The Value of Country.
    */
    $country = $this->country_code;

    /*
    * The Value of IP Address.
    */
    $ip = $this->ip;

    /*
    * IP Block Boolean Value. If Boolean is True user is blocked.
    */
    $ip_blocked;

    /*
    * Country Block Boolean Value. If Boolean is True user is blocked.
    */
    $country_block;

    /*
    * Check if user's country is blocked or not.
    * If country found blocked $country_block sets to TRUE.
    */
    //If Country List not empty.
    if ( ! empty( $options['sbv_options']['ban_some']['banned']['country'] ) ) {
      foreach ( $options['sbv_options']['ban_some']['banned']['country'] as $con ) {
        foreach ( $con as $country_code => $name ) {
          if ( $country == $country_code ) {

            //Set Boolean.
            $country_block = true;
          }
        }
      }
    }

    /*
    * Check if user's IP is blocked or not.
    * If IP found Blocked $ip_blocked sets to TRUE.
    */
    //If IP List is not empty
    if ( ! empty( $options['sbv_options']['ban_some']['banned']['ip'] ) ) {

      //If User's IP Match.
      if ( in_array( $ip, $options['sbv_options']['ban_some']['banned']['ip'] ) ) {

        //Set Boolean.
        $ip_blocked = true;
      }
    }

    /*
    * Redirects user if country or IP is blocked.
    */
    if ( $country_block || $ip_blocked ) {

      //Create Stats Data.
      $data = [
        'ip' => $this->ip,
        'hostname' => $this->hostname,
        'city' => $this->city,
        'region' => $this->region,
        'country' => $this->country_code,
        'loc' => $this->loc,
        'org' => $this->org,
        'date' => date( 'Y-m-d H:i:s' )
      ];

      //Initiate Stats Class.
      $stats = new Stats();

      //Insert Data.
      $stats->insert_stats( $data );

      //Redirect User.
      $this->redirect();
    }
  }

  /*
  * Method to proccess Specific Block.
  */
  private function do_block_all() {

    //The Plugin's Options.
    $options = $this->options;

    /*
    * The Value of Country Code.
    */
    $country = $this->country_code;

    /*
    * The Value of IP Address from Session.
    */
    $ip = $this->ip;

    /*
    * Ip Exception Boolean Value. If Boolean is True user is excempted.
    */
    $ip_excempted;

    /*
    * Country Exception Boolean Value If Boolean is True user is excempted.
    */
    $country_excempted;

    /*
    * Check if user's country is excempted or not.
    * If country found excempted $country_excempted sets to TRUE.
    */
    //If country list not empty.
    if ( ! empty( $options['sbv_options']['ban_all']['exception']['country'] ) ) {
      foreach ( $options['sbv_options']['ban_all']['exception']['country'] as $con ) {
        foreach ( $con as $country_code => $name ) {
          if ( $country == $country_code ) {

            //Set Boolean.
            $country_excempted = true;
          }
        }
      }
    }

    /*
    * Check if user's IP is excempted or not.
    * If IP found excempted $ip_excempted sets to TRUE.
    */
    //If IP List not empty.
    if ( ! empty( $options['sbv_options']['ban_all']['exception']['ip'] ) ) {

      //If User's IP Matched.
      if ( in_array( $ip, $options['sbv_options']['ban_all']['exception']['ip'] ) ) {

        //Set Boolean.
        $ip_excempted = true;
      }
    }

    /*
    * Redirects user if country or IP is blocked.
    */
    if ( ! $country_excempted && ! $ip_excempted ) {

      /*
      * Check if Unblock Crawler SEO Bots is enabled and IP Address is Crawler Bot or not.
      */
      if ( ! $this->is_bot() ) {

        //Create Stats Data.
        $data = [
          'ip' => $this->ip,
          'hostname' => $this->hostname,
          'city' => $this->city,
          'region' => $this->region,
          'country' => $this->country_code,
          'loc' => $this->loc,
          'org' => $this->org,
          'date' => date( 'Y-m-d H:i:s' )
        ];

        //Initiate Stats Class.
        $stats = new Stats();

        //Insert Data.
        $stats->insert_stats( $data );


        //Redirect User.
        $this->redirect();
      }
    }
  }

  //Returns the uri of redirect page.
  private function page_redirect_uri() {

    //The Options.
    $options = $this->options;

    //The Page Redirect.
    $page_redirect = $options['sbv_options']['page_redirect'];

    $page = '';

    //Loop to get post name.
    foreach ( $page_redirect as $p => $name ) {
      $page .= $p;
    }

    return $page;
  }

  //Check if Unblock Crawler SEO Bots enabled or not. Return Boolean.
  private function is_bots_enabled() {

    //The Options.
    $options = $this->options;

    //If Unblock Crawler SEO Bots enabled.
    if ( $options['sbv_options']['bots'] ) {

      //Return Bool.
      return true;
    }

    //Return Bool.
    return false;
  }

  //Check if IP Address is a Crawler SEO Bot or not. Return Boolean.
  private function is_bot() {

    //Check if Unblock Crawler Bots is enabled or not.
    if ( $this->is_bots_enabled() ) {

      //Get File Contents and Decode JSON to PHP Array of ip-bots.json file.
      $bots = json_decode( file_get_contents( SBV . '/includes/ip-bots.json' ), true );

      //Check if IP Address is Crawler SEO Bot or not.
      if ( in_array( $this->ip, $bots['bots'] ) ) {

        //Return Bool.
        return true;
      }

      //Return Bool.
      return false;
    }

    //Return Bool.
    return false;
  }
}
