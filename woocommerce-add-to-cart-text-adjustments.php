<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Plugin Name: Woocommerce Add To Cart Text Adjustments
 * Plugin URI:  https://googlydigital.com
 * Description: Change the text on the Add to Cart buttons on the single product page and products page
 * Version:     1.0.0
 * Author:      Buckeyeclyde
 * Author URI:  https://googlydigital.com
 * Text Domain: woocommerce-add-to-cart-text-adjustments
 * Domain Path: /languages
 * License:     GPL2
 */

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { // Check if woocommerce is active
	
	// Add the sub menu page to the WP Admin menu
	add_action( 'admin_menu', 'dashboard_products_cart_button', 9999 );

	// Define and create the submenu page
	function dashboard_products_cart_button() {
	   add_submenu_page( 'edit.php?post_type=product', 'Adjust WooCommerce Product Add to Cart Buttons', 'Product Add to Cart Buttons', 'edit_products', 'add-to-cart-buttons', 'dashboard_products_cart_button_callback', 9999 );
	}
	 
	// Add the page contents to the new sub menu page
	function dashboard_products_cart_button_callback() {
		
	// WP Admin Panel, Product, Product Add to Cart Buttons page; add the title and link to the Settings, Product Add to Cart Buttons page
	?>
	<div>
		<h1>Adjust Product Add to Cart Button Text</h1>
		<p>The settings for this feature are located in Settings, Custom Plugin Menu. <a href="/wp-admin/options-general.php?page=plugin">Click here to go there now.</a></p>
	</div>
	<?php
	}

} else { // Checked if woocommerce is active, and if not display a warning message
	
	function wcsh_notice() {
		?>
		<div class="error notice">
		<p>WARNING: This plugin requires the WooCommerce plugin to be activated. Please activate Woocommerce.</p>
		</div>
		<?php
	}
	add_action( 'admin_notices', 'wcsh_notice' );
	
}
?>
