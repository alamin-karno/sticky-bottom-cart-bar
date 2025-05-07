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

// Enqueue styles
add_action('wp_enqueue_scripts', 'cbcb_enqueue_styles');
function cbcb_enqueue_styles() {
    if (is_product()) {
        wp_enqueue_style('cbcb-style', plugin_dir_url(__FILE__) . 'style.css');
    }
}

// Load settings
require_once plugin_dir_path(__FILE__) . 'admin/settings-page.php';

// Add the fixed bar HTML
add_action('wp_footer', 'cbcb_output_bar');
function cbcb_output_bar() {
    if (!is_product()) return;

    $options = get_option('cbcb_settings');
    global $product;

    echo '<div class="cbcb-fixed-bar">';
        if (!empty($options['show_variation'])) {
            woocommerce_template_single_add_to_cart();
        } else {
            echo '<form class="cart" method="post" enctype="multipart/form-data">';
                echo '<input type="hidden" name="add-to-cart" value="' . esc_attr($product->get_id()) . '">';
                echo '<button type="submit" class="single_add_to_cart_button button alt">' . esc_html__('Add to Cart', 'woocommerce') . '</button>';
                if (!empty($options['show_buy_now'])) {
                    echo '<button type="button" class="button buy_now_button">' . esc_html__('Buy Now', 'custom-bottom-cart-bar') . '</button>';
                }
            echo '</form>';
        }
        if (!empty($options['show_price'])) {
            echo '<div class="cbcb-price">' . $product->get_price_html() . '</div>';
        }
    echo '</div>';
}

// JS for Buy Now button redirect
add_action('wp_footer', 'cbcb_buy_now_script');
function cbcb_buy_now_script() {
    if (!is_product()) return;
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buyNowBtn = document.querySelector('.buy_now_button');
            if (buyNowBtn) {
                buyNowBtn.addEventListener('click', function () {
                    document.querySelector('form.cart').submit();
                    window.location.href = "<?php echo wc_get_checkout_url(); ?>";
                });
            }
        });
    </script>
    <?php
}
