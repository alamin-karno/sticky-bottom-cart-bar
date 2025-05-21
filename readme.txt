=== Sticky Bottom Cart Bar ===
Contributors: alaminkarno
Tags: add to cart, sticky bar, buy now, floating button, woocommerce plugin
Requires at least: 5.0
Tested up to: 6.8
Requires PHP: 7.2
Stable tag: 1.1.1
License: MIT
License URI: https://opensource.org/licenses/MIT
Donate link: https://www.buymeacoffee.com/alaminkarno

Adds a sticky Add to Cart and Buy Now button at the bottom of WooCommerce product pages with a customizable interface.

== Description ==

Sticky Bottom Cart Bar is a lightweight plugin that enhances your WooCommerce product pages by showing a sticky bar at the bottom. It allows users to quickly add products to their cart or buy immediately with a stylish and responsive button interface.

== Features ==

* Adds a sticky Add to Cart and Buy Now bar fixed to the bottom of WooCommerce single product pages.
* Displays product price dynamically, including updates when product variations are selected.
* Compatible with both simple and variable WooCommerce products.
* Uses native WooCommerce add-to-cart form to ensure full compatibility.
* Sticky bar visibility toggles based on scroll direction: hides when scrolled to the bottom, fades in when scrolling up.
* Clean, minimal, and responsive design optimized for both mobile and desktop.
* Lightweight and easy to customize via CSS.
* Translation Ready: All plugin strings can be translated into other languages.

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory or install it via the WordPress plugin installer.
2. Activate the plugin through the 'Plugins' screen in WordPress.

== Frequently Asked Questions ==

= Will this work with any theme? =
Yes, it works with most WooCommerce-compatible themes.

= Does this support variable products? =
Yes, it automatically detects selected variations before adding to cart.

== Screenshots ==

1. Sticky Add to Cart and Buy Now bar displayed on a single product page

== Changelog ==

= 1.1.1 =
* Security: Added nonces to AJAX actions.
* Robustness: Improved AJAX error handling and made client-side strings translatable.
* CSS: Removed all `!important` flags by increasing selector specificity.
* Localization: Prepared PHP files for full translation and added text domain.
* Documentation: Updated readme files for accuracy.

= 1.0.0 =
* Initial release: Sticky Add to Cart + Buy Now button.

== Upgrade Notice ==

= 1.1.1 =
This version includes security enhancements, improved AJAX handling, CSS refinements, and full localization support. Please update.

= 1.0.0 =
Initial version.
