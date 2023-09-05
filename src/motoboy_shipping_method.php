<?php 
add_filter('woocommerce_shipping_methods', 'add_motoboy_shipping');
function add_motoboy_shipping($methods)
{
    $methods['motoboy_shipping'] = 'motoboy_shipping';
    return $methods;
}
add_action('woocommerce_shipping_init', 'motoboy_shipping');
function motoboy_shipping()
{
    class Motoboy_Shipping extends WC_Shipping_Method
    {

        public function __construct($instance_id = 0)
        {
            $this->id = 'motoboy_shipping';
            $this->instance_id = absint($instance_id);
            $this->domain = 'motoboy_shipping';
            $this->method_title = __('Entrega por motoboy', $this->domain);
            $this->method_description = __('Entrega por motoboy', $this->domain);
            $this->title = __('Entrega por motoboy', $this->domain);
            $this->supports = array(
                'shipping-zones',
                'instance-settings',
                'instance-settings-modal',
            );

            $this->instance_form_fields = array(
                'enabled' => array(
                    'title'         => __('Enable/Disable'),
                    'type'             => 'checkbox',
                    'label'         => __('Enable this shipping method'),
                    'default'         => 'yes',
                ),
                'title' => array(
                    'title'         => __('Method Title'),
                    'type'             => 'text',
                    'description'     => __('This controls the title which the user sees during checkout.'),
                    'default'        => __('Entrega por motoboy'),
                    'desc_tip'        => true
                )
            );

            $this->enabled = $this->get_option('enabled');
            $this->title   = __('Entrega por motoboy', $this->domain);

            add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
        }

        public function calculate_shipping($package = array())
        {
            $this->add_rate(array(
                'id'    => $this->id . $this->instance_id,
                'label' => $this->title,
                'cost'  => 0,
            ));
        }
    }
}