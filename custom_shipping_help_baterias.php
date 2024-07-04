<?php
/**
* Plugin Name: Custom Shipping Help Baterias
* Plugin URI: https://github.com/lucassdantas/custom_shipping_date
* Update URI: https://github.com/lucassdantas/custom_shipping_date
* Description: Custom shipping configurations for help baterias
* Version: 1.0.0
* Author: R&D Marketing Digital 
* Author URI: https://rdmarketing.com.br/
**/

defined('ABSPATH') or die();
if(!function_exists('add_action')){
    die;
}

require_once plugin_dir_path(__FILE__). 'src/add_help_baterias_shipping.php';
require_once plugin_dir_path(__FILE__). 'src/restrict_help_baterias_shipping_on_cart_and_checkout.php';
require_once plugin_dir_path(__FILE__). 'src/restrict_help_baterias_shipping_by_category.php';
require_once plugin_dir_path(__FILE__). 'src/check_and_add_custom_shipping_method.php';
require_once plugin_dir_path(__FILE__). 'src/script_custom_date.php';

  