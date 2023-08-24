<?php
/**
* Plugin Name: Custom Shipping Date
* Plugin URI: https://github.com/lucassdantas/custom_shipping_date
* Description: Custom dates for woocommerce shipping
* Version: 0.1
* Author: R&D Marketing Digital
* Author URI: https://rdmarketing.com.br/
**/

defined('ABSPATH') or die();
if(!function_exists('add_action')){
    die;
}
require_once plugin_dir_path( __FILE__ ). 'src/custom_date_field.php';
require_once plugin_dir_path( __FILE__ ). 'src/script_custom_date.php';

  