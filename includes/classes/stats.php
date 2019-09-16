<?php

/*
* Class for Statistics Functionalities.
*/

namespace Shogo\SBV\Classes;

//Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class Stats {

  /*
  * DB Table name.
  */
  private $table;

  public function __construct() {

    global $wpdb;

    //Global Table.
    $this->table = $wpdb->prefix . 'sbv_statistics';
  }

  /*
  * Method to insert ststistics to the database.
  */
  public function insert_stats( $infos ) {

    global $wpdb;

    //Check if value is an array.
    if ( is_array( $infos ) ) {

      //Insert Data.
      $wpdb->insert( $this->table, $infos, [ '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' ] );
    }
  }

  /*
  * Method to get Stats Counts.
  */
  public function get_counts() {

    global $wpdb;

    //Query to get count.
    $count = $wpdb->get_var("SELECT COUNT(*) FROM $this->table");

    //return count.
    return $count;
  }

  /*
  * Method to get Distunct Result List.
  */
  public function get_distinct() {

    global $wpdb;

    //List of Countries Blocked DISTINCT Results.
    $hits = $wpdb->get_results( "SELECT DISTINCT `country` FROM $this->table GROUP BY `country` ORDER BY COUNT(*) DESC" );

    return $hits;
  }

  /*
  * Method to get Stats Percentage.
  */
  public function get_percent( $country_code ) {

    global $wpdb;

    //Get Counts.
    $counts = $this->get_counts();

    //Count the number of requested country code.
    $country_count = $wpdb->get_var( "SELECT COUNT(*) FROM $this->table WHERE `country` = '$country_code'" );

    //Convert stats to percentage.
    $percent = $country_count / $counts * 100;

    //Round Up Decimal Values.
    $percent = ceil( $percent );

    //Return Result.
    return $percent;
  }

  //Method to get IPs Blocked.
  public function get_ips_blocked() {

    global $wpdb;

    //Get All Data.
    $ips = $wpdb->get_results( "SELECT DISTINCT `ip` FROM $this->table GROUP BY `ip` ORDER BY COUNT(*) DESC;" );

    //Return Data.
    return $ips;
  }

  //Method to get IP's Hostname.
  public function get_hostname( $ip ) {

    global $wpdb;

    //Get Hostname.
    $hostname = $wpdb->get_var( "SELECT `hostname` FROM $this->table WHERE `ip` = '$ip'" );

    //Return Data.
    return $hostname;
  }

  //Method to get IP's City.
  public function get_city( $ip ) {

    global $wpdb;

    //Get City.
    $city = $wpdb->get_var( "SELECT `city` FROM $this->table WHERE `ip` = '$ip'" );

    //Return Data.
    return $city;
  }

  //Method to get IP's Region.
  public function get_region( $ip ) {

    global $wpdb;

    //Get Region.
    $region = $wpdb->get_var( "SELECT `region` FROM $this->table WHERE `ip` = '$ip'" );

    //Return Data.
    return $region;
  }

  //Method to get IP's Country Code.
  public function get_country_code( $ip ) {

    global $wpdb;

    //Get Country Code.
    $country_code = $wpdb->get_var( "SELECT `country` FROM $this->table WHERE `ip` = '$ip'" );

    //Return Data.
    return $country_code;
  }

  //Method to get IP's ISP Provider.
  public function get_isp_provider( $ip ) {

    global $wpdb;

    //Get ISP Provider.
    $isp = $wpdb->get_var( "SELECT `org` FROM $this->table WHERE `ip` = '$ip'" );

    //Return Data.
    return $isp;
  }

  //Method to get IP's Location.
  public function get_location( $ip ) {

    global $wpdb;

    //Get Location.
    $location = $wpdb->get_var( "SELECT `loc` FROM $this->table WHERE `ip` = '$ip'" );

    //Return Data.
    return $location;
  }

  //Method to count specific IP Address.
  public function count_ips( $ip ) {

    global $wpdb;

    //Count Data.
    $hits = $wpdb->get_var( "SELECT COUNT(*) FROM $this->table WHERE `ip` = '$ip'" );

    //Return Data.
    return $hits;
  }

  //Method to Clear Stats.
  public function clear_stats() {

    global $wpdb;

    //Delete All Data.
    $wpdb->query( "DELETE FROM $this->table" );
  }

  //Method to convert country_code to country name.
  public function country_name( $country_code ) {

    switch ( $country_code ) {
      case 'A1':
        $country = '(Anonymous Proxy)';
      break;

      case 'A2':
        $country = '(Satellite Provider)';
      break;

      case 'AC':
        $country = 'Acension Island';
      break;

      case 'AD':
        $country = 'Andorra';
      break;

      case 'AE':
        $country = 'United Arab Emirates';
      break;

      case 'AF':
        $country = 'Afghanistan';
      break;

      case 'AG':
        $country = 'Antigua and Barbuda';
      break;

      case 'AI':
        $country = 'Anguilla';
      break;

      case 'AL':
        $country = 'Abania';
      break;

      case 'AM';
        $country = 'Armenia';
      break;

      case 'AN':
        $country = 'Netherlands Antilles';
      break;

      case 'AO':
        $country = 'Angola';
      break;

      case 'AQ':
        $country = 'Antartica';
      break;

      case 'AR':
        $country = 'Argentina';
      break;

      case 'AS':
        $country = 'American Samoa';
      break;

      case 'AT':
        $country = 'Austria';
      break;

      case 'AU':
        $country = 'Australia';
      break;

      case 'AW':
        $country = 'Aruba';
      break;

      case 'AX':
        $country = 'Aland';
      break;

      case 'AZ':
        $country = 'Azerbaijan';
      break;

      case 'BA':
        $country = 'Bosnia and Herzegovina';
      break;

      case 'BB':
        $country = 'Barbados';
      break;

      case 'BD':
        $country = 'Bangladesh';
      break;

      case 'BE':
        $country = 'Belgium';
      break;

      case 'BF':
        $country = 'Burkina Faso';
      break;

      case 'BG':
        $country = 'Bulgaria';
      break;

      case 'BH':
        $country = 'Bahrain';
      break;

      case 'BI':
        $country = 'Burundi';
      break;

      case 'BJ':
        $country = 'Benin';
      break;

      case 'BM':
        $country = 'Bermuda';
      break;

      case 'BN':
        $country = 'Brunei';
      break;

      case 'BO':
        $country = 'Bolivia';
      break;

      case 'BQ':
        $country = 'Bonaire';
      break;

      case 'BR':
        $country = 'Brazil';
      break;

      case 'BS':
        $country = 'Bahamas';
      break;

      case 'BT':
        $country = 'Butan';
      break;

      case 'BV':
        $country = 'Bouvet Island';
      break;

      case 'BW':
        $country = 'Borswana';
      break;

      case 'BY':
        $country = 'Belarus';
      break;

      case 'BZ':
        $country = 'Belize';
      break;

      case 'CA':
        $country = 'Canada';
      break;

      case 'CC':
        $country = 'Cocos (Keeling) Islands';
      break;

      case 'CD':
        $country = 'Democratic Republic of the Congo';
      break;

      case 'CF':
        $country = 'Central African Republic';
      break;

      case 'CG':
        $country = 'Republic of the Congo';
      break;

      case 'CH':
        $country = 'Switzerland';
      break;

      case 'CI':
        $country = 'Côte d`lvoire';
      break;

      case 'CK':
        $country = 'Cook Island';
      break;

      case 'CL':
        $country = 'Chile';
      break;

      case 'CM':
        $country = 'Cameroon';
      break;

      case 'CN':
        $country = 'People`s Republic of China';
      break;

      case 'CO':
        $country = 'Colombia';
      break;

      case 'CS':
        $country = 'Czechoslovakia, Serbia and Montenegro';
      break;

      case 'CU':
        $country = 'Cuba';
      break;

      case 'CV':
        $country = 'Cape Verde';
      break;

      case 'CW':
        $country = 'Curacao';
      break;

      case 'CX':
        $country = 'Christmas Island';
      break;

      case 'CY':
        $country = 'Cyprus';
      break;

      case 'CZ':
        $country = 'Czech Republic';
      break;

      case 'DD':
        $country = 'East Germany';
      break;

      case 'DE':
        $country = 'Germany';
      break;

      case 'DJ':
        $country = 'Djbouti';
      break;

      case 'DK':
        $country = 'Denmark';
      break;

      case 'DM':
        $country = 'Dominica';
      break;

      case 'DO':
        $country = 'Dominican Republic';
      break;

      case 'DZ':
        $country = 'Algeria';
      break;

      case 'EC':
        $country = 'Ecuador';
      break;

      case 'EE':
        $country = 'Estonia';
      break;

      case 'EG':
        $country = 'Egypt';
      break;

      case 'EH':
        $country = 'Western Sahara';
      break;

      case 'ER':
        $country = 'Eritrea';
      break;

      case 'ES':
        $country = 'Spain';
      break;

      case 'ET':
        $country = 'Ethiopia';
      break;

      case 'EU':
        $country = 'Europian Union';
      break;

      case 'FI':
        $country = 'Finland';
      break;

      case 'FJ':
        $country = 'Fiji';
      break;

      case 'FK':
        $country = 'Falkland Islands';
      break;

      case 'FM':
        $country = 'Federated States of Micronesia';
      break;

      case 'FO':
        $country = 'Faroe Islands';
      break;

      case 'FR':
        $country = 'France';
      break;

      case 'GA':
        $country = 'Gabon';
      break;

      case 'GB':
        $country = 'United Kingdom';
      break;

      case 'GD':
        $country = 'Grenada';
      break;

      case 'GF':
        $country = 'French Guiana';
      break;

      case 'GG':
        $country = 'Guernsey';
      break;

      case 'GH':
        $country = 'Ghana';
      break;

      case 'GI':
        $country = 'Gibraltar';
      break;

      case 'GL':
        $country = 'Greenland';
      break;

      case 'GM':
        $country = 'The Gambia';
      break;

      case 'GN':
        $country = 'Guinea';
      break;

      case 'GP':
        $country = 'Guadeloupe';
      break;

      case 'GQ':
        $country = 'Equatorial Guinea';
      break;

      case 'GR':
        $country = 'Greece';
      break;

      case 'GS':
        $country = 'South Geogia and the South Sandwich Islands';
      break;

      case 'GT':
        $country = 'Guatamala';
      break;

      case 'GU':
        $country = 'Guam';
      break;

      case 'GW':
        $country = 'Guinea-Bissau';
      break;

      case 'GY':
        $country = 'Guyana';
      break;

      case 'HK':
        $country = 'Hongkong';
      break;

      case 'HM':
        $country = ' Heard Island and McDonald Islands';
      break;

      case 'HN':
        $country = 'Honduras';
      break;

      case 'HR':
        $country = 'Croatia';
      break;

      case 'HT':
        $country = 'Haiti';
      break;

      case 'HU':
        $country = 'Hungary';
      break;

      case 'ID':
        $country = 'Indonesia';
      break;

      case 'IE':
        $country = 'Ireland';
      break;

      case 'IL':
        $country = 'Israel';
      break;

      case 'IM':
        $country = 'Isle of Man';
      break;

      case 'IN':
        $country = 'India';
      break;

      case 'IO':
        $country = 'British Indian Ocean Territory';
      break;

      case 'IQ':
        $country = 'Iraq';
      break;

      case 'IR':
        $country = 'IRAN';
      break;

      case 'IS':
        $country = 'Iceland';
      break;

      case 'IT':
        $country = 'Italy';
      break;

      case 'JE':
        $country = 'Jersey';
      break;

      case 'JM':
        $country = 'Jamaica';
      break;

      case 'JO':
        $country = 'Jordan';
      break;

      case 'JP':
        $country = 'Japan';
      break;

      case 'KE':
        $country = 'Kenya';
      break;

      case 'KG':
        $country = 'Kygryzstan';
      break;

      case 'KH':
        $country = 'Cambodia';
      break;

      case 'KI':
        $country = 'Kribati';
      break;

      case 'KM':
        $country = 'Comoros';
      break;

      case 'KN':
        $country = 'Saints Kitts and Nevis';
      break;

      case 'KP':
        $country = 'Democratic People`s Republic of Korea';
      break;

      case 'KR':
        $country = 'Republic of Korea';
      break;

      case 'KRD':
        $country = 'Kurdistan';
      break;

      case 'KW':
        $country = 'Kuwait';
      break;

      case 'KY':
        $country = 'Cayman Islands';
      break;

      case 'KZ':
        $country = 'Kazakhstan';
      break;

      case 'LA':
        $country = 'LAOS';
      break;

      case 'LB':
        $country = 'Lebanon';
      break;

      case 'LC':
        $country = 'Saint Lucia';
      break;

      case 'LI':
        $country = 'Liechtenstein';
      break;

      case 'LK':
        $country = 'Sri Lanka';
      break;

      case 'LR':
        $country = 'Liberia';
      break;

      case 'LS':
        $country = 'Lesotho';
      break;

      case 'LT':
        $country = 'Lithuania';
      break;

      case 'LU':
        $country = 'Luexmbourg';
      break;

      case 'LV':
        $country = 'Latvia';
      break;

      case 'LY':
        $country = 'Libya';
      break;

      case 'MA':
        $country = 'Morocco';
      break;

      case 'MC':
        $country = 'Monaco';
      break;

      case 'MD':
        $country = 'Moldova';
      break;

      case 'ME':
        $country = 'Montenegro';
      break;

      case 'MG':
        $country = 'Madagascar';
      break;

      case 'MH':
        $country = 'Marshall Islands';
      break;

      case 'MK':
        $country = 'Macedonia';
      break;

      case 'ML':
        $country = 'Mali';
      break;

      case 'MM':
        $country = 'Myanmar';
      break;

      case 'MN':
        $country = 'Mongolia';
      break;

      case 'MO':
        $country = 'Macau';
      break;

      case 'MP':
        $country = 'Northern Mariana Islands';
      break;

      case 'MQ':
        $country = 'Martinique';
      break;

      case 'MR':
        $country = 'Mauritania';
      break;

      case 'MS':
        $country = 'Montserrat';
      break;

      case 'MT':
        $country = 'Malta';
      break;

      case 'MU':
        $country = 'Mauritius';
      break;

      case 'MV':
        $country = 'Maldives';
      break;

      case 'MW':
        $country = 'Malawi';
      break;

      case 'MX':
        $country = 'Mexico';
      break;

      case 'MY':
        $country = 'Malaysia';
      break;

      case 'MZ':
        $country = 'Mozambique';
      break;

      case 'NA':
        $country = 'Namibia';
      break;

      case 'NC':
        $country = 'New Caledonia';
      break;

      case 'NE':
        $country = 'Niger';
      break;

      case 'NF':
        $country = 'Norfolk Island';
      break;

      case 'NG':
        $country = 'Nigeria';
      break;

      case 'NI':
        $country = 'Nicaragua';
      break;

      case 'NL':
        $country = 'Netherlands';
      break;

      case 'NO':
        $country = 'Norway';
      break;

      case 'NP':
        $country = 'Nepal';
      break;

      case 'NR':
        $country = 'Nauru';
      break;

      case 'NU':
        $country = 'Ninue';
      break;

      case 'NZ':
        $country = 'New Zeland';
      break;

      case 'OM':
        $country = 'Oman';
      break;

      case 'PA':
        $country = 'Panama';
      break;

      case 'PE':
        $country = 'Peru';
      break;

      case 'PF':
        $country = 'French Polynesia';
      break;

      case 'PG':
        $country = 'Papau New Guinea';
      break;

      case 'PH':
        $country = 'Philippines';
      break;

      case 'PK':
        $country = 'Pakistan';
      break;

      case 'PL':
        $country = 'Poland';
      break;

      case 'PM':
        $country = 'Saint-Pierre and Miquelon';
      break;

      case 'PN':
        $country = 'Pitcairn Islands';
      break;

      case 'PR':
        $country = 'Puerto Rico';
      break;

      case 'PS':
        $country = 'State of Palestine';
      break;

      case 'PT':
        $country = 'Portugal';
      break;

      case 'PW':
        $country = 'Palau';
      break;

      case 'PY':
        $country = 'Paraguay';
      break;

      case 'QA':
        $country = 'Qatar';
      break;

      case 'RE':
        $country = 'Reunion';
      break;

      case 'RO':
        $country = 'Romania';
      break;

      case 'RS':
        $country = 'Sebria';
      break;

      case 'RU':
        $country = 'Russia';
      break;

      case 'RW':
        $country = 'Rwanda';
      break;

      case 'SA':
        $country = 'Saudi Arabia';
      break;

      case 'SB':
        $country = 'Solomon Islands';
      break;

      case 'SC':
        $country = 'Seychelles';
      break;

      case 'SD':
        $country = 'Sudan';
      break;

      case 'SE':
        $country = 'Sweden';
      break;

      case 'SG':
        $country = 'Singapore';
      break;

      case 'SH':
        $country = 'Saint Helena';
      break;

      case 'SI':
        $country = 'Slovenia';
      break;

      case 'SJ':
        $country = 'Svalbard and Jan Mayen Islands';
      break;

      case 'SK':
        $country = 'Slovakia';
      break;

      case 'SL':
        $country = 'Sierra Leone';
      break;

      case 'SM':
        $country = 'San Marino';
      break;

      case 'SN':
        $country = 'Senegal';
      break;

      case 'SO':
        $country = 'Somalia';
      break;

      case 'SR':
        $country = 'Suriname';
      break;

      case 'SS':
        $country = 'South Sudan';
      break;

      case 'ST':
        $country = 'Sao Tome and Principe';
      break;

      case 'SU':
        $country = 'Soviet Union';
      break;

      case 'SV':
        $country = 'El Salvador';
      break;

      case 'SX':
        $country = ' Sint Maarten';
      break;

      case 'SY':
        $country = 'Syria';
      break;

      case 'SZ':
        $country = 'Swaziland';
      break;

      case 'TC':
        $country = 'Turks and Caicos Islands';
      break;

      case 'TD':
        $country = 'Chad';
      break;

      case 'TF':
        $country = 'French Southern and Atarctic Lands';
      break;

      case 'TG':
        $country = 'Togo';
      break;

      case 'TH':
        $country = 'Thailand';
      break;

      case 'TJ':
        $country = 'Tajikistan';
      break;

      case 'TK':
        $country = 'Tokelau';
      break;

      case 'TL':
        $country = 'East Timor';
      break;

      case 'TR':
        $country = 'Turkey';
      break;

      case 'TT':
        $country = 'Trinidad and Tobago';
      break;

      case 'TV':
        $country = 'Tuvalu';
      break;

      case 'TW':
        $country = 'Taiwan';
      break;

      case 'TZ':
        $country = 'Tazania';
      break;

      case 'UA':
        $country = 'Ukraine';
      break;

      case 'UG':
        $country = 'Uganda';
      break;

      case 'UK':
        $country = 'United Kingdom';
      break;

      case 'US':
        $country = 'United States of America';
      break;

      case 'UY':
        $country = 'Urugay';
      break;

      case 'UZ':
        $country = 'Uzbekistan';
      break;

      case 'VC':
        $country = 'Vatican City';
      break;

      case 'VC':
        $country = 'Sain Vincent and The Grenadines';
      break;

      case 'VE':
        $country = 'Venenzuela';
      break;

      case 'VG':
        $country = 'British Virgin Islands';
      break;

      case 'VI':
        $country = 'United States Virgin Islands';
      break;

      case 'VN':
        $country = 'Vietnam';
      break;

      case 'VU':
        $country = 'Vanuatu';
      break;

      case 'WF':
        $country = 'Wallis and Futuna';
      break;

      case 'YE':
        $country = 'Yemen';
      break;

      case 'YT':
        $country = 'Mayotte';
      break;

      case 'YU':
        $country = 'SFR Yugoslavia, FR Yugoslavia';
      break;

      case 'ZA':
        $country = 'South Africa';
      break;

      case 'ZM':
        $country = 'Zambia';
      break;

      case 'ZR':
        $country = 'Zaire';
      break;

      case 'ZW':
        $country = 'Zimbabwe';
      break;

      default:
        $country = 'Unknown';
    }

    return $country;
  }
}
