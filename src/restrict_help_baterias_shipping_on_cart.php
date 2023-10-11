<?php 


defined('ABSPATH') or die();
if(!function_exists('add_action')){
    die;
}
function restrict_help_baterias_shipping_on_cart($cart) {
    $count = 0;
    foreach($cart->get_cart() as $cart_item){
        $single_product_quantity = $cart_item['quantity'];
        if($single_product_quantity > 1){
            $count += ($single_product_quantity - 1);
        }  
        $count++;
    }

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
}
add_action('woocommerce_before_calculate_totals', 'restrict_help_baterias_shipping_on_cart');