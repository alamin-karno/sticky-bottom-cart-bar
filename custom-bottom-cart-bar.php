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

// Add Settings link to Plugins page
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'cbcb_add_settings_link');

function cbcb_add_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=custom_bottom_cart_bar">' . __('Settings') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}

// Load settings page for customization
if (is_admin()) {
    require_once plugin_dir_path(__FILE__) . 'admin/settings-page.php';
}

// Output the fixed bar
add_action('wp_footer', 'cbcb_output_bar');
function cbcb_output_bar() {
    if (!is_product()) return;

    $options = get_option('cbcb_settings');
    global $product;

    $show_on_desktop = !empty($options['show_on_desktop']);
    $show_on_tablet = !empty($options['show_on_tablet']);
    $show_on_mobile = !empty($options['show_on_mobile']);

    // Don't show bar if none are enabled
    if (!$show_on_desktop && !$show_on_tablet && !$show_on_mobile) return;

    echo '<div class="cbcb-fixed-bar' . 
        ($show_on_desktop ? ' cbcb-desktop' : '') . 
        ($show_on_tablet ? ' cbcb-tablet' : '') . 
        ($show_on_mobile ? ' cbcb-mobile' : '') . 
        '">';

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

// JS for Buy Now and variation validation
add_action('wp_footer', 'cbcb_buy_now_script');
function cbcb_buy_now_script() {
    if (!is_product()) return;
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const buyNowBtn = document.querySelector('.buy_now_button');
        const addToCartBtn = document.querySelector('.single_add_to_cart_button');
        const variationForm = document.querySelector('form.variations_form');

        function hasUnselectedVariations() {
            if (!variationForm) return false;
            const selects = variationForm.querySelectorAll('select');
            for (const select of selects) {
                if (!select.value) return true;
            }
            return false;
        }

        function showVariationWarning() {
            if (!document.querySelector('.cbcb-warning')) {
                const warning = document.createElement('div');
                warning.className = 'cbcb-warning';
                warning.textContent = 'Please select all product options (like size or color).';
                document.querySelector('.cbcb-fixed-bar').appendChild(warning);
                setTimeout(() => warning.remove(), 4000);
            }
        }

        if (buyNowBtn) {
            buyNowBtn.addEventListener('click', function () {
                if (hasUnselectedVariations()) {
                    showVariationWarning();
                } else {
                    variationForm?.submit();
                    setTimeout(() => {
                        window.location.href = "<?php echo wc_get_checkout_url(); ?>";
                    }, 500);
                }
            });
        }

        if (addToCartBtn) {
            addToCartBtn.addEventListener('click', function (e) {
                if (hasUnselectedVariations()) {
                    e.preventDefault();
                    showVariationWarning();
                }
            });
        }
    });
    </script>
    <?php
}
?>
