<?php 

// Adicione o filtro para modificar as opções de entrega
add_filter('woocommerce_package_rates', 'custom_shipping_methods_based_on_categories', 10, 2);

function custom_shipping_methods_based_on_categories($rates, $package) {
    // Verifique se a entrega por motoboy está disponível
    $motoboy_available = true;
    $car_available = false;
    // Verificamos se algum produto não pertence às categorias "baterias de carro" ou "baterias de moto"
    foreach (WC()->cart->get_cart() as $cart_item) {
        $product_id = $cart_item['product_id'];
        $term_names = wp_get_post_terms($product_id, 'product_cat', array('fields' => 'names'));

        if (!in_array('Baterias de Carro', $term_names) && !in_array('Baterias de Moto', $term_names)) {
            $motoboy_available = false;
            break;
        }
    }

    // Desative a entrega por motoboy se a condição não for atendida
    if (!$motoboy_available) {
        unset($rates['motoboy_shipping']);
    }
    if (!$car_available){
        unset($rates['car_shipping']);
    }

    return $rates;
}
