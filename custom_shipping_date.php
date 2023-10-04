<?php
/**
* Plugin Name: Custom Shipping Date
* Plugin URI: https://github.com/lucassdantas/custom_shipping_date
* Description: Custom date for woocommerce shipping
* Version: 0.5
* Author: R&D Marketing Digital 
* Author URI: https://rdmarketing.com.br/
**/

defined('ABSPATH') or die();
if(!function_exists('add_action')){
    die;
}

require_once plugin_dir_path(__FILE__). 'src/add_motoboy_shipping_method.php';
require_once plugin_dir_path(__FILE__). 'src/restrict_motoboy_shipping.php';
require_once plugin_dir_path( __FILE__ ). 'src/check_and_add_custom_shipping_method.php';
require_once plugin_dir_path( __FILE__ ). 'src/script_custom_date.php';

  