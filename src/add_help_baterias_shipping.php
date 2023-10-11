<?php 
add_filter('woocommerce_shipping_methods', 'add_help_baterias_shipping');
function add_help_baterias_shipping($methods)
{
    $methods['help_baterias_shipping'] = 'help_baterias_shipping';
    return $methods;
}
add_action('woocommerce_shipping_init', 'help_baterias_shipping');
function help_baterias_shipping()
{
    class Help_Baterias_Shipping extends WC_Shipping_Method
    {

        public function __construct($instance_id = 0)
        {
            $this->id = 'help_baterias_shipping';
            $this->instance_id = absint($instance_id);
            $this->domain = 'help_baterias_shipping';
            $this->method_title = __('Entrega Help Baterias', $this->domain);
            $this->method_description = __('Entrega Help Baterias', $this->domain);
            $this->title = __('Entrega Help Baterias', $this->domain);
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
                    'default'        => __('Entrega Help Baterias'),
                    'desc_tip'        => true
                )
            );

            $this->enabled = $this->get_option('enabled');
            $this->title   = __('Entrega Help Baterias', $this->domain);

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