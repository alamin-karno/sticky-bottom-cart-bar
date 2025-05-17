<?php
/**
 * Plugin Name: Sticky Bottom Cart Bar
 * Plugin URI: https://github.com/alamin-karno/sticky-bottom-cart-bar
 * Description: Adds a sticky Add to Cart & Buy Now bar at the bottom of WooCommerce product pages.
 * Version: 1.1.0
 * Author: Md. Al-Amin
 * Author URI: https://www.linkedin.com/in/alaminkarno/
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Requires at least: 5.0
 * Requires PHP: 7.2
 */

if (!defined('ABSPATH')) exit;

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

    wp_localize_script('sbcb-script', 'sbcb_params', [
        'ajax_url' => WC_AJAX::get_endpoint('add_to_cart'),
        'cart_url' => wc_get_cart_url(),
        'checkout_url' => wc_get_checkout_url()
    ]);
});

// Render Sticky Bar
add_action('woocommerce_after_add_to_cart_form', function () {
    global $product;

    ?>
    <div id="sbcb-sticky-bar">
        <div id="sbcb-price-wrapper">
            <div id="sbcb-price-label">Total:</div>
            <?php
            $price_to_show = $product->get_sale_price() ? $product->get_sale_price() : $product->get_regular_price();
            $price_html = wc_price($price_to_show);
            ?>
            <div id="sbcb-price-container"><?php echo $price_html; ?></div>
        </div>
        <div id="sbcb-buttons">
            <button id="sbcb-add-to-cart"><span class="sbcb-label">ADD TO CART</span><span class="sbcb-loader"></span></button>
            <button id="sbcb-buy-now"><span class="sbcb-label">BUY NOW</span><span class="sbcb-loader"></span></button>
        </div>
    </div>
    <?php
});
