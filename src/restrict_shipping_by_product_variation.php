<?php 

add_filter('woocommerce_package_rates', 'filter_shipping_methods', 10, 2);
function filter_shipping_methods($rates, $package) {
    foreach ($rates as $rate_id => $rate) {
        if($rate->method_id !== 'help_baterias_shipping'){
            unset($rates[$rate_id]);
        }
    }
    return $rates;
}


add_action('woocommerce_before_cart', 'display_notice_for_shipping');
add_action('woocommerce_checkout_before_customer_details', 'display_notice_for_shipping');
function display_notice_for_shipping() {
    wc_print_notice(__('As entregas por transportadora não estão disponíveis para produtos com devolução de sucata.', 'woocommerce'), 'notice');
}