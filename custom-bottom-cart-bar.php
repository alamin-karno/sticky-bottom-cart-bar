<?php
/**
 * Plugin Name: Custom Bottom Cart Bar
 * Description: Adds a fixed Add to Cart & Buy Now bar at the bottom of product pages.
 * Version: 1.0
 * Author: Md. Al-Amin
 */

// Enqueue the CSS file only on single product pages
add_action('wp_enqueue_scripts', 'cbcb_enqueue_styles');
function cbcb_enqueue_styles() {
    if (is_product()) {
        wp_enqueue_style('cbcb-style', plugin_dir_url(__FILE__) . 'style.css');
    }
}

// Add the fixed bar HTML to the footer
add_action('wp_footer', 'cbcb_output_bar');
function cbcb_output_bar() {
    if (!is_product()) return;
    global $product;

    echo '<div class="cbcb-fixed-bar">';
        woocommerce_template_single_add_to_cart();
    echo '</div>';
}
