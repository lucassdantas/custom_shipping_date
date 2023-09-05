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
			$is_50minutes_shipping = false;
			function add_category_checker_filter(&$is_50minutes_shipping)
			{
				echo $is_50minutes_shipping;
				function check_product_category( $cart_item_data, $cart_item ) 
				{
					$product_id = $cart_item['product_id'];
					$term_names = wp_get_post_terms( $product_id, 'product_cat', array( 'fields' => 'names' ) );
				
					foreach ($term_names as $index => $category) {
						if($category == 'Baterias De Motos' || $category == "Baterias de Carro" || $category == 'Receba em 50 minutos'){
							echo $category;
						}
					}
				   
					return $cart_item_data;
				}
				add_filter( 'woocommerce_get_item_data', 'check_product_category', 10, 2);
			}
			add_category_checker_filter($is_50minutes_shipping);

			$fields['billing']['shipping_type'] = array(
				'label'     => __('Tipo de entrega', 'woocommerce'),
				'type'		=> 'select',
				'placeholder'   => _x('Selecione o tipo de entrega', 'placeholder', 'woocommerce'),
				'required'  => true,
				'class'     => array('form-row-wide'),
				'clear'     => true
			);
			
			if($is_50minutes_shipping){
				$fields['billing']['shipping_type']['options'] = array (
					'Entrega imediata' => 'Entrega imediata',
					'Próximo dia útil' => 'Próximo dia útil',
					'Entrega agendada' => 'Agendar entrega'
				);
			}else{
				$fields['billing']['shipping_type']['options'] = array (
					'Entrega no mesmo dia' => 'Entrega no mesmo dia',
					'Próximo dia útil' => 'Próximo dia útil',
					'Entrega agendada' => 'Agendar entrega'
				);
			}
			
			
			$fields['billing']['shipping_type']['priority'] = 8;
			
			
			$fields['billing']['shipping_date'] = array(
				'type' => 'date',
				'label'     => __('Data aproximada da entrega', 'woocommerce'),
				'placeholder'   => _x('Data aproximada da entrega', 'placeholder', 'woocommerce'),
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
	$shippingType =  get_post_meta( $order->get_id(), '_shipping_type', true );
	echo '<p><strong>'.__('Tipo de entrega:').'</strong> ' . $shippingType . '</p>';
	
	if($shippingType === 'Entrega agendada') {
		$shippingDate = get_post_meta( $order->get_id(), '_shipping_date', true );
		$shippingDate = date("d/m/Y", strtotime(str_replace(', ', '-', $shippingDate)));
		echo '<p><strong>'.__('Data:').'</strong> ' . $shippingDate . '</p>';
	}
}
