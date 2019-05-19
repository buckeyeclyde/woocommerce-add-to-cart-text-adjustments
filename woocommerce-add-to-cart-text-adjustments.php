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
	
	// add the admin options page (Settings, Add to Cart Buttons)
	add_action('admin_menu', 'plugin_admin_add_page');
	function plugin_admin_add_page() {
		// add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);
		add_options_page('Add to Cart Buttons Page', 'Add to Cart Buttons', 'manage_options', 'plugin', 'plugin_woo_atc_buttons_options_page');
	}
	
	function plugin_woo_atc_buttons_options_page() {
		?>
		<div>
			<h1>Adjust WooCommerce Product Add to Cart Button Text</h1>
			<form action="options.php" method="post">
				<!-- Output nonce, action, and option_page fields for a settings page. -->
				<!-- settings_fields( $option_group ) Must be called inside the form tag -->
				<?php settings_fields('plugin_options'); ?>
				
				<!-- callback function to output all the sections and fields that were added to that $page -->
				<?php do_settings_sections('plugin'); ?>
				
				<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
			</form>
		</div>
		<?php
	}	 
		
	// add the admin settings sections and fields
	add_action('admin_init', 'plugin_admin_init');
	function plugin_admin_init(){
		// register_setting( $option_group, $option_name, $args = array() )
		register_setting( 
			'plugin_options', 
			'plugin_options', 
			'plugin_options_validate'
		);
		// add_settings_section( $id, $title, $callback, $page )
		add_settings_section(
			'plugin_main', 
			'Product Add to Cart Buttons Text', 
			'plugin_section_text', 
			'plugin'
		);
		// add_settings_field( $id, $title, $callback, $page, $section, $args )
		add_settings_field(
			'plugin_text_string', 
			'New Add to Cart Buttons Text:', 
			'plugin_setting_string', 
			'plugin', 
			'plugin_main'
		);
	}
	
	// Description for the section
	function plugin_section_text() {
		echo '<p>Change the text to the product Add to Cart button.</p>';
	}
	
	// Add the input field for the button text change
	function plugin_setting_string() {
		$options = get_option('plugin_options');
		echo "<input id='plugin_text_string' name='plugin_options[text_string]' size='40' type='text' value='{$options["text_string"]}' />";
	} 
	
	// validate our options - note: returning options
	function plugin_options_validate($input) {
		$options = get_option('plugin_options');
		$options['text_string'] = trim($input['text_string']);
		$text_string = isset($_POST['text_string']) ? sanitize_text_field($_POST['text_string']) : '';
		// finally, strip out any html entered in the field
		$options['text_string'] =  wp_filter_nohtml_kses($input['text_string']);
		return $options;
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
