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
 * Text Domain: sticky-bottom-cart-bar
 */

if (!defined('ABSPATH')) exit;

// Get plugin version dynamically
$plugin_data = get_file_data(__FILE__, array('Version' => 'Version'), false);
$plugin_version = isset($plugin_data['Version']) ? $plugin_data['Version'] : '1.1.0';

// Enqueue CSS and JS
add_action('wp_enqueue_scripts', function () use ($plugin_version) {
    if (!is_product()) return;

    wp_enqueue_style(
        'cbcb-style',
        plugin_dir_url(__FILE__) . 'style.css',
        array(),
        $plugin_version
    );

    wp_enqueue_script(
        'cbcb-script',
        plugin_dir_url(__FILE__) . 'script.js',
        array('jquery'),
        $plugin_version,
        true
    );

    wp_localize_script('cbcb-script', 'cbcb_params', [
        'ajax_url' => WC_AJAX::get_endpoint('add_to_cart'),
        'cart_url' => wc_get_cart_url(),
        'checkout_url' => wc_get_checkout_url()
    ]);
});

// Render Sticky Bar
add_action('woocommerce_after_add_to_cart_form', function () {
    global $product;

    ?>
    <div id="cbcb-sticky-bar">
        <div id="cbcb-price-container"><?php echo $product->get_price_html(); ?></div>
        <div id="cbcb-buttons">
            <button id="cbcb-add-to-cart"><span class="cbcb-label">ADD TO CART</span><span class="cbcb-loader"></span></button>
            <button id="cbcb-buy-now"><span class="cbcb-label">BUY NOW</span><span class="cbcb-loader"></span></button>
        </div>
    </div>
    <style>
        body.single-product { padding-bottom: 100px !important; }

        /* Hide only default Add to Cart & Buy Now buttons inside form.cart */
        form.cart button.single_add_to_cart_button,
        form.cart .buy-now-button {
            display: none !important;
        }
        
        /* Hide entire quantity input section */
        form.cart .quantity {
            display: none !important;
        }

    </style>
    <?php
});
