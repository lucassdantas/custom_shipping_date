<?php 


defined('ABSPATH') or die();
if(!function_exists('add_action')){
    die;
}

function restrict_help_baterias_shipping_on_cart($cart) {
    foreach($cart->get_cart() as $cart_item){
        echo "<pre>";
        print_r($cart_item);
        echo "</pre>";
        
    }
}
add_action('woocommerce_before_calculate_totals', 'restrict_help_baterias_shipping_on_cart');