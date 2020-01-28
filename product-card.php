<?php
/*
 * Plugin Name:       Product Card
 */


require_once plugin_dir_path( __FILE__ ) . "includes/function.php";
require_once plugin_dir_path( __FILE__ ) . "includes/ovveride-template-woocommerce.php";

add_action('wp_enqueue_scripts', 'vn_product__card');
function vn_product__card()
{
    wp_enqueue_style('product__card', plugin_dir_url(__FILE__) . 'assets/main.min.css', '', null);
    wp_enqueue_script('product__card', plugin_dir_url(__FILE__) . 'assets/product-card.min.js', array('jquery'), null, true);
}