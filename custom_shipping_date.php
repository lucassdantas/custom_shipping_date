<?php
/**
* Plugin Name: Custom Shipping Date
* Plugin URI: https://github.com/lucassdantas/calculadora-bruno-investimentos
* Description: Custom dates for woocommerce shipping
* Version: 0.1
* Author: R&D Marketing Digital
* Author URI: https://rdmarketing.com.br/
**/

defined('ABSPATH') or die();
if(!function_exists('add_action')){
    die;
}

function script_custom_date()
{
    ?>
    <script>
        let ds = value => document.querySelector(value),
            c  = value => console.log(value),
            deliveryTypeSelect =  ds("#billing_delivery_type"),
            deliveryDateField = ds("#") 

    </script>
    
    <?php
}
  
    add_action('wp_footer', 'costScript');