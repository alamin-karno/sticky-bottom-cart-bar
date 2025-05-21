<?php
/**
 * Plugin Name: Sticky Bottom Cart Bar
 * Plugin URI: https://github.com/alamin-karno/sticky-bottom-cart-bar
 * Description: Adds a sticky Add to Cart & Buy Now bar at the bottom of WooCommerce product pages.
 * Version: 1.2.0
 * Author: Md. Al-Amin
 * Author URI: https://www.linkedin.com/in/alaminkarno/
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Requires at least: 5.0
 * Requires PHP: 7.2
 * Text Domain: sticky-bottom-cart-bar
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) exit;

// Load plugin textdomain
add_action('plugins_loaded', 'sbcb_load_textdomain');
function sbcb_load_textdomain() {
    load_plugin_textdomain('sticky-bottom-cart-bar', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

// Get plugin version dynamically
$plugin_data = get_file_data(__FILE__, array('Version' => 'Version'), false);
$plugin_version = isset($plugin_data['Version']) ? $plugin_data['Version'] : '1.1.0';

// Enqueue CSS and JS
add_action('wp_enqueue_scripts', function () use ($plugin_version) {
    if (!is_product()) return;

    $css_path = plugin_dir_url(__FILE__) . 'assets/css/style.css';
    $js_path  = plugin_dir_url(__FILE__) . 'assets/js/script.js';
    
    wp_register_style('sbcb-style', $css_path, array(), $plugin_version);
    wp_enqueue_style('sbcb-style');

    wp_register_script('sbcb-script', $js_path, array('jquery'), $plugin_version, true);
    wp_enqueue_script('sbcb-script');

    // Prepare parameters for the script
    $params_array = [
        'ajax_url' => WC_AJAX::get_endpoint('add_to_cart'),
        'cart_url' => wc_get_cart_url(),
        'checkout_url' => wc_get_checkout_url(),
        'ajax_nonce' => wp_create_nonce('woocommerce-add-to-cart'), // Use WooCommerce's action
        'text_select_variation' => __('Please select a product variation before proceeding.', 'sticky-bottom-cart-bar'),
        'text_fill_required_fields' => __('Please fill all required product fields before adding to cart.', 'sticky-bottom-cart-bar'),
        'text_ajax_error' => __('An error occurred. Please try again.', 'sticky-bottom-cart-bar')
    ];

    wp_localize_script('sbcb-script', 'sbcb_params', $params_array);
});

// Render Sticky Bar
add_action('woocommerce_after_add_to_cart_form', function () {
    global $product;

    ?>
    <div id="sbcb-sticky-bar">
        <div id="sbcb-price-wrapper">
            <div id="sbcb-price-label"><?php echo esc_html__('Total:', 'sticky-bottom-cart-bar'); ?></div>
            <?php
            $price_to_show = $product->get_sale_price() ? $product->get_sale_price() : $product->get_regular_price();
            $price_html = wc_price($price_to_show);
            ?>
            <div id="sbcb-price-container"><?php echo wp_kses_post($price_html); ?></div>
        </div>
        <div id="sbcb-buttons">
            <button id="sbcb-add-to-cart"><span class="sbcb-label"><?php echo esc_html__('ADD TO CART', 'sticky-bottom-cart-bar'); ?></span><span class="sbcb-loader"></span></button>
            <button id="sbcb-buy-now"><span class="sbcb-label"><?php echo esc_html__('BUY NOW', 'sticky-bottom-cart-bar'); ?></span><span class="sbcb-loader"></span></button>
        </div>
    </div>
    <?php
});
