<?php

add_action('admin_menu', 'cbcb_add_admin_menu');
add_action('admin_init', 'cbcb_settings_init');

function cbcb_add_admin_menu() {
    add_options_page(
        'WooCommerce Sticky Bottom Cart Bar',
        'Bottom Cart Bar',
        'manage_options',
        'custom_bottom_cart_bar',
        'cbcb_options_page'
    );
}

function cbcb_settings_init() {
    // Default options for settings
    $default_settings = array(
        'show_buy_now' => true,
        'show_price' => false,
        'show_variation' => false,
        'show_on_desktop' => true,
        'show_on_tablet' => true,
        'show_on_mobile' => true,
    );

    // Get current settings, merge with default settings
    $options = get_option('cbcb_settings', $default_settings);

    // Register the settings group
    register_setting('cbcb_settings_group', 'cbcb_settings');

    add_settings_section(
        'cbcb_settings_section',
        __('Display Options', 'custom-bottom-cart-bar'),
        null,
        'custom_bottom_cart_bar'
    );

    add_settings_field(
        'show_buy_now',
        __('Show Buy Now Button', 'custom-bottom-cart-bar'),
        'cbcb_checkbox_field_render',
        'custom_bottom_cart_bar',
        'cbcb_settings_section',
        ['label_for' => 'show_buy_now']
    );

    add_settings_field(
        'show_price',
        __('Show Product Price', 'custom-bottom-cart-bar'),
        'cbcb_checkbox_field_render',
        'custom_bottom_cart_bar',
        'cbcb_settings_section',
        ['label_for' => 'show_price']
    );

    add_settings_field(
        'show_variation',
        __('Enable Variation/Full Form', 'custom-bottom-cart-bar'),
        'cbcb_checkbox_field_render',
        'custom_bottom_cart_bar',
        'cbcb_settings_section',
        ['label_for' => 'show_variation']
    );

    add_settings_field(
        'show_on_desktop',
        __('Show on Desktop', 'custom-bottom-cart-bar'),
        'cbcb_checkbox_field_render',
        'custom_bottom_cart_bar',
        'cbcb_settings_section',
        ['label_for' => 'show_on_desktop']
    );

    add_settings_field(
        'show_on_tablet',
        __('Show on Tablet', 'custom-bottom-cart-bar'),
        'cbcb_checkbox_field_render',
        'custom_bottom_cart_bar',
        'cbcb_settings_section',
        ['label_for' => 'show_on_tablet']
    );

    add_settings_field(
        'show_on_mobile',
        __('Show on Mobile', 'custom-bottom-cart-bar'),
        'cbcb_checkbox_field_render',
        'custom_bottom_cart_bar',
        'cbcb_settings_section',
        ['label_for' => 'show_on_mobile']
    );
}

// Render checkbox field
function cbcb_checkbox_field_render($args) {
    $options = get_option('cbcb_settings');
    $checked = !empty($options[$args['label_for']]) ? 'checked' : '';
    ?>
    <input type='checkbox' name='cbcb_settings[<?php echo $args['label_for']; ?>]' <?php echo $checked; ?> />
    <?php
}

function cbcb_options_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('WooCommerce Sticky Bottom Cart Bar Settings', 'custom-bottom-cart-bar'); ?></h1>
        <form action='options.php' method='post'>
            <?php
            settings_fields('cbcb_settings_group');
            do_settings_sections('custom_bottom_cart_bar');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
?>
