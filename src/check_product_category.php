<?php 
function check_product_category( $cart_item_data, $cart_item ) {
    $product_id = $cart_item['product_id'];
    $term_names = wp_get_post_terms( $product_id, 'product_cat', array( 'fields' => 'names' ) );

    foreach ($term_names as $index => $category) {
        echo $category;
        if($category == 'Bateria de moto' || $category == "Bateria de carro"){
            echo '<pre id="teste">';
            echo 'oi';
            echo '</pre>';
        }
    }
   
	return $cart_item_data;
}
add_filter( 'woocommerce_get_item_data', 'check_product_category', 10, 2 );