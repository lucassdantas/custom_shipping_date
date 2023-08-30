<?php
add_action('woocommerce_before_checkout_form', 'check_and_add_custom_shipping_method');
function check_and_add_custom_shipping_method() {
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
		add_filter('woocommerce_checkout_fields', 'custom_date_field');
		function custom_date_field($fields)
		{
			$fields['billing']['shipping_type'] = array(
				'label'     => __('Tipo de entrega', 'woocommerce'),
				'type'		=> 'select',
				'placeholder'   => _x('Selecione o tipo de entrega', 'placeholder', 'woocommerce'),
				'required'  => true,
				'class'     => array('form-row-wide'),
				'clear'     => true
			);
			
			$fields['billing']['shipping_type']['options'] = array (
				'Entrega imediata' => 'Entrega imediata',
				'Próximo dia útil' => 'Próximo dia útil',
				'Entrega agendada' => 'Agendar entrega'
			);
			
			$fields['billing']['shipping_type']['priority'] = 8;
			
			
			$fields['billing']['shipping_date'] = array(
				'type' => 'date',
				'label'     => __('Data de entrega', 'woocommerce'),
				'placeholder'   => _x('Data de entrega', 'placeholder', 'woocommerce'),
				'required'  => false,
				'class'     => array('form-row-wide'),
				'clear'     => true
			);

			$fields['billing']['shipping_date']['priority'] = 9;
			return $fields;
		}
	}
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
	echo '<p><strong>'.__('Tipo de entrega:').'</strong> ' . get_post_meta( $order->get_id(), '_shipping_type', true ) . '</p>';
	echo '<p><strong>'.__('Data:').'</strong> ' . get_post_meta( $order->get_id(), '_shipping_date', true ) . '</p>';
}
