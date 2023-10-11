<?php 

defined('ABSPATH') or die();
if(!function_exists('add_action')){
    die;
}

// Salvar os campos como metadados da ordem
add_action('woocommerce_checkout_update_order_meta', 'save_custom_shipping_fields');

function save_custom_shipping_fields($order_id) {
	if ($_POST['shipping_type']) {
		update_post_meta($order_id, '_shipping_type', sanitize_text_field($_POST['shipping_type']));
    }
	
    if ($_POST['shipping_date']) {
		update_post_meta($order_id, '_shipping_date', sanitize_text_field($_POST['shipping_date']));
    }
}

add_action( 'woocommerce_admin_order_data_after_shipping_address', 'display_shipping_type_on_order', 10, 1 );

function display_shipping_type_on_order($order){
	$shippingType =  get_post_meta( $order->get_id(), '_shipping_type', true );
	echo '<p><strong>'.__('Tipo de entrega:').'</strong> ' . $shippingType . '</p>';
	
	if($shippingType === 'Entrega agendada') {
		$shippingDate = get_post_meta( $order->get_id(), '_shipping_date', true );
		$shippingDate = date("d/m/Y", strtotime(str_replace(', ', '-', $shippingDate)));
		echo '<p><strong>'.__('Data:').'</strong> ' . $shippingDate . '</p>';
	}
}