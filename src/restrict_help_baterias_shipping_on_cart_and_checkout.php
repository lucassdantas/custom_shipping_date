<?php 

defined('ABSPATH') or die();
if(!function_exists('add_action')){
    die;
}

function restrict_help_baterias_shipping_on_cart_and_checkout($cart) {
    $remove_other_shipping_methods = false;

    foreach($cart->get_cart() as $cart_item){
        if(in_array('sem-sucata', $cart_item['variation'])){
            $remove_other_shipping_methods = true;
            break;
        }
    }

    if($remove_other_shipping_methods){
        require_once plugin_dir_path(__FILE__). './restrict_shipping_by_product_variation.php';
    }
}

add_action('woocommerce_before_calculate_totals', 'restrict_help_baterias_shipping_on_cart_and_checkout');



/*
#Removed because the limit dont exit anymore
if($count > 6){
    add_filter( 'woocommerce_package_rates', 'disable_shipping_method_based_on_postcode', 10, 2 );
    function disable_shipping_method_based_on_postcode( $rates, $package ) {
        foreach ( $rates as $rate_id => $rate ) {
            unset( $rates['help_baterias_shipping34'] );
        }
        return $rates;
    }
}
*/