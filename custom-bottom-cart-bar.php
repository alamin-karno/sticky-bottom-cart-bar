<?php
/**
 * Plugin Name: WooCommerce Sticky Bottom Cart Bar
 * Plugin URI: https://github.com/alamin-karno/woocommerce-sticky-bottom-cart-bar
 * Description: Adds a fixed Add to Cart & Buy Now bar at the bottom of WooCommerce product pages with customization options.
 * Version: 1.0.0
 * Author: Md. Al-Amin
 * Author URI: https://www.linkedin.com/in/alaminkarno/
 * License: MIT
 * License URI: https://github.com/alamin-karno/woocommerce-sticky-bottom-cart-bar/blob/main/LICENSE
 * Text Domain: woocommerce-sticky-bottom-cart-bar
 * Domain Path: /languages
 */

 if (!defined('ABSPATH')) exit;

 // Enqueue CSS/JS
 add_action('wp_enqueue_scripts', function () {
     if (!is_product()) return;
 
     wp_enqueue_style('cbcb-style', plugin_dir_url(__FILE__) . 'style.css');
     wp_enqueue_script('cbcb-script', plugin_dir_url(__FILE__) . 'script.js', ['jquery'], null, true);
 
     wp_localize_script('cbcb-script', 'cbcb_params', [
         'ajax_url' => WC_AJAX::get_endpoint('add_to_cart'),
         'cart_url' => wc_get_cart_url(),
         'checkout_url' => wc_get_checkout_url()
     ]);
 });
 
 // Add sticky bar
 add_action('woocommerce_after_add_to_cart_form', function () {
     ?>
     <div id="cbcb-sticky-bar">
         <button id="cbcb-add-to-cart"><span class="cbcb-label">ADD TO CART</span><span class="cbcb-loader"></span></button>
         <button id="cbcb-buy-now"><span class="cbcb-label">BUY NOW</span><span class="cbcb-loader"></span></button>
     </div>
     <style>
         body.single-product {
             padding-bottom: 100px !important;
         }
     </style>
     <?php
 });