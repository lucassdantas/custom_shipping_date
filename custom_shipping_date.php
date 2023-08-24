<?php
/**
* Plugin Name: Custom Shipping Date
* Plugin URI: https://github.com/lucassdantas/custom_shipping_date
* Description: Custom dates for woocommerce shipping
* Version: 0.1
* Author: R&D Marketing Digital
* Author URI: https://rdmarketing.com.br/
**/

defined('ABSPATH') or die();
if(!function_exists('add_action')){
    die;
}
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
		'entrega_imediata' => 'Entrega imediata',
		'proximo_dia_util' => 'Próximo dia útil',
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

function display_shipping_type_on_order(){
	    echo '<p><strong>'.__('Entrega:').':</strong> ' . get_post_meta( $order->get_id(), '_shipping_type', true ) . '</p>';

}

function script_custom_date()
{
    ?>
    <script>
        
        if(location.pathname == '/finalizar-compra/'){
            let waitForElementToExist = (selector) => {
                    return new Promise(resolve => {
                        if (document.querySelector(selector)) {
                            return resolve(document.querySelector(selector));
                        }

                        const observer = new MutationObserver(() => {
                            if (document.querySelector(selector)) {
                                resolve(document.querySelector(selector));
                                observer.disconnect();
                            }
                        });

                        observer.observe(document.body, {
                            subtree: true,
                            childList: true,
                        });
                    });
                },
                ds = value => document.querySelector(value),
                c  = value => console.log(value),
                delivertTyleSelectTitle,
                date;

            waitForElementToExist('#shipping_type')
                .then( shippingType => {
                    waitForElementToExist('#shipping_date_field')
                        .then(shippingDateField => {
                            shippingDateField.style.display = 'none'
                            shippingDateField.querySelector('.optional').innerHTML = ''
                            shippingType.addEventListener('change', e => {
                                if(shippingType.selectedIndex === 0 || shippingType.selectedIndex === 1 ){
                                    shippingDateField.style.display = 'none'
                                }else{
                                    shippingDateField.style.display = ''
                                    if(shippingType.selectedIndex === 2){
                                        date = new Date(shippingDateField.value)
                                    }
                                }
                            })
                        })
                    })
        }
    </script>
    <?php
}
  
add_action('wp_footer', 'script_custom_date');