<?php
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

add_action( 'woocommerce_admin_order_data_after_shipping_address', 'display_shipping_type_on_order', 10, 1 );

function display_shipping_type_on_order($order){
	echo '<p><strong>'.__('Tipo de entrega:').'</strong> ' . get_post_meta( $order->get_id(), '_shipping_type', true ) . '</p>';
	echo '<p><strong>'.__('Data:').'</strong> ' . get_post_meta( $order->get_id(), '_shipping_date', true ) . '</p>';
}


