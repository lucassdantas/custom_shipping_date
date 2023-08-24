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
	 $fields['billing']['shipping_date'] = array(
        'label'     => __('Data da entrega', 'woocommerce'),
		'type'		=> 'select',
		'placeholder'   => _x('Data da entrega', 'placeholder', 'woocommerce'),
		'required'  => false,
		'class'     => array('form-row-wide'),
		'clear'     => true
     );
	
	$fields['billing']['shipping_date']['options'] = array (
		'entrega_imediata' => 'Entrega imediata',
		'proximo_dia_util' => 'Próximo dia útil',
		'Entrega agendada' => 'Agendar entrega'
	);
	return $fields;
}

add_action( 'woocommerce_admin_order_data_after_shipping_address', 'display_shipping_date_on_order', 10, 1 );

function display_shipping_date_on_order(){
	    echo '<p><strong>'.__('Entrega:').':</strong> ' . get_post_meta( $order->get_id(), '_shipping_date', true ) . '</p>';

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
                deliveryTypeSelect,
                delivertTyleSelectTitle,
                deliveryDateField,
                date;

            waitForElementToExist('#select2-billing_delivery_type-container').then( el => {
                
                deliveryTypeSelect =  ds("#select2-billing_delivery_type-container")
                waitForElementToExist('#coderockz_woo_delivery_date_datepicker')
                .then( el => {
                    deliveryDateField = ds("#coderockz_woo_delivery_date_datepicker")
                    
                    deliveryTypeSelect.addEventListener('change', e => {
                            
                        if(deliveryTypeSelect.selectedIndex === 0){
                            deliveryDateField.style.display = 'none'
                        }else{
                            deliveryDateField.style.display = ''
                            if(deliveryTypeSelect.selectedIndex === 1){
                                date = new Date(deliveryDateField.value)
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