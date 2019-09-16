<?php

/*
* Class to get User's Information returned from ipinfo.io.
*/

namespace Shogo\SBV\Classes;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class UsersInfo {

  /*
  * Global IP Address.
  */
  public $ip;

  /*
  * Global Country Code.
  */
  public $country_code;

  /*
  * Global Hostname.
  */
  public $hostname;

  /*
  * Global City.
  */
  public $city;

  /*
  * Global Region.
  */
  public $region;

  /*
  * Global Location.
  */
  public $loc;

  /*
  * Global ISP Provider.
  */
  public $org;

  public function __construct() {

    //Get user's information from ipinfo.io and decode json to php array.
    $infos = json_decode( file_get_contents( 'https://ipinfo.io/' ), true );

    //Set Global IP Address.
    $this->ip = $infos['ip'];

    //Set Global Contry Code.
    $this->country_code = $infos['country'];

    //Set Global Hostname.
    $this->hostname = $infos['hostname'];

    //Set Global City.
    $this->city = $infos['city'];

    //Set Global Region.
    $this->region = $infos['region'];

    //Set Global Location.
    $this->loc = $infos['loc'];

    //Sey Global ISP Provider.
    $this->org = $infos['org'];
  }
}
