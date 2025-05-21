# Changelog

## [1.2.0] - 2025-05-21

### Added
- Nonce security for AJAX add-to-cart and buy-now operations.
- Error handling and user feedback for AJAX failures.
- Full internationalization support (translation readiness for all user-facing strings).
- Plugin prepared for `.pot` file generation for easier translation.

### Improved
- CSS styling by removing all `!important` declarations for better theme compatibility.
- JavaScript robustness and maintainability.
- Accuracy of `README.md` and `readme.txt` documentation.

### Fixed
- Removed misleading references to a non-existent settings page in documentation.

## [1.1.1] - 2025-05-17

### Fixed
- Escaped product price output using WordPress-compliant functions to enhance security.
- Addressed WordPress plugin review feedback by improving output handling to align with best practices.

## [1.1.0] - 2025-05-10

### Added
- Sticky bar now displays product price on the left side.
- Dynamic price update when selecting product variations.
- Scroll-based visibility for the sticky bar: hides when user reaches the bottom of the page and reappears with fade animation when scrolling up.

### Changed
- Layout updated: "Add to Cart" and "Buy Now" buttons are now on the right side.
- Enhanced styling and responsiveness of the sticky bar.
- JavaScript optimized for real-time price updates on variation selection.
- Added fade-in and fade-out animations for sticky bar visibility toggle based on scroll direction.

### Fixed
- Ensured compatibility with variable products and default WooCommerce behavior.
- Resolved issue where sticky buttons wouldn't behave properly on variable product pages if no variation was selected.

---

## [1.0.0] - 2025-05-07

- Initial release with sticky "Add to Cart" and "Buy Now" buttons on WooCommerce product pages.
