# Sticky Bottom Cart Bar

A lightweight custom WordPress plugin that adds a fixed **"Add to Cart"** and **"Buy Now"** bar to the bottom of WooCommerce single product pages.

## 🛒 Features

- Adds a sticky cart bar to the bottom of product pages.
- Displays product price dynamically, including updates when variations are selected.
- Works with both simple and variable products.
- Uses native WooCommerce add-to-cart form for full compatibility.
- Sticky bar visibility toggles based on scroll direction (hides at the bottom, fades in when scrolling up).
- Clean and minimal design with responsive styling.
- Lightweight and easy to customize via CSS.
- Translation Ready: All plugin strings can be translated into other languages.

## 🚀 Installation

1. Download or clone the repository:
   ```bash
   git clone https://github.com/alamin-karno/sticky-bottom-cart-bar
   ```
   Or download the ZIP file from the [releases page](https://github.com/alamin-karno/sticky-bottom-cart-bar/releases)
2. Zip the plugin folder:
  Compress the `sticky-bottom-cart-bar` folder into a `.zip` file.
3. Upload to WordPress:
  - Go to `Plugins → Add New → Upload Plugin`
  - Select your `.zip` file and click Install Now
  - Activate the plugin

## 🔧 Customization
You can edit the CSS in `assets/css/style.css` to match your theme or move it into your theme’s stylesheet if needed.

## 📁 File Structure
  ```bash
  sticky-bottom-cart-bar/
  │
  ├── sticky-bottom-cart-bar.php        # Main plugin code
  ├── assets/
  │   ├── css/style.css                 # Sticky bar styling
  │   └── js/script.js                  # JavaScript for sticky bar functionality
  ├── languages/                        # .pot file and translations (to be added)
  │   └── sticky-bottom-cart-bar.pot    # Template for translations
  ├── readme.txt                        # WordPress plugin directory readme
  ├── README.md                         # Plugin documentation
  ├── LICENSE                           # License information
  └── CHANGELOG.md                      # Changelog
  ```

## 📦 Compatibility
- WordPress 5.0+
- PHP 7.2+
- WooCommerce (latest version recommended)

## 🛠️ Support & Contributions

If you encounter issues, have questions, or would like to contribute:

- **🐞 Bug Reports & Feature Requests**  
  Please open an issue on the [GitHub repository](https://github.com/alamin-karno/sticky-bottom-cart-bar/issues).

- **🤝 Contributing**  
  See the [Contributing Guidelines](CONTRIBUTING.md) for how to get started.

- **📬 General Inquiries**  
  Feel free to contact me directly via [email](mailto:alamin.karno@gmail.com).

- **🙋 Support**  
  Check the [FAQ in readme.txt](readme.txt) or open an issue for help.


## 📜 License
[MIT License](LICENSE). Free to use and modify.

**Made with ❤️ for WordPress + WooCommerce**
