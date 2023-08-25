<?php
add_action('woocommerce_before_checkout_billing_form', 'check_shipping_method');
function check_shipping_method() {
	$current_shipping_name = "";
	$current_shipping_method = WC()->session->get( 'chosen_shipping_methods' );
	$packages = WC()->shipping()->get_packages();
	$package = $packages[0];
	$available_methods = $package['rates'];
	foreach ($available_methods as $key => $method) {
		if($current_shipping_method[0] == $method->id){
			$current_shipping_name = $method->label;
		}
	}
	if($current_shipping_name === 'Entrega por Motoboy'){
		require_once plugin_dir_path( __FILE__ ) . 'src/custom_date_field.php';
	}
}