<?php 
function check_product_category( $cart_item_data, $cart_item ) {
    $product_id = $cart_item['product_id'];
    $term_names = wp_get_post_terms( $product_id, 'product_cat', array( 'fields' => 'names' ) );

    foreach ($term_names as $index => $category) {
        if($category == 'Baterias De Motos' || $category == "Baterias de Carro" || $category == 'Receba em 50 minutos'){
            echo $category;
        }
    }
   
	return $cart_item_data;
}
add_filter( 
    'woocommerce_get_item_data', 
    function($cart_item_data, $cart_item) {
        check_product_category($cart_item_data, $cart_item);
    },
    10, 2 
);