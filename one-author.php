<?php
/**
 * Plugin Name:       One Author
 * Description:       Adds the author info in post page of theme The-One.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Janak Patel
 * License:           GPL v3 or later
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       one-author
 * Domain Path:       /languages
 */

require_once ABSPATH . 'wp-content\\plugins\\one-author\\inc\\helpers\\autoloader.php';
// /////////////////////////////////////////////////////  Class Instantiation  ////////////////////////////
use OneAuthor\Inc\Classes\Admin_Menu;
$admin_menu_instance = new Admin_Menu();

require_once ABSPATH . 'wp-content\\plugins\\one-author\\inc\\helpers\\data-handler.php';

// /////////////////////////////////////////////////////   Constant definition  ////////////////////////////
define( 'ONE_AUTHOR_PATH', plugin_dir_path( __FILE__ ) );

// /////////////////////////////////////////////////////   Hooks setup  ///////////////////////////////////
register_activation_hook( __FILE__, 'create_the_custom_table' );
add_action( 'admin_enqueue_scripts', 'enqueuer' );
add_action( 'wp_ajax_reg_avatar', 'mini_form_data_extractor' );
add_action( 'wp_ajax_gods_eye', 'ajax_data_fetcher' );

/**
 * Handles the assets enqueueing process.
 *
 * @return void
 */
function enqueuer() {
	wp_enqueue_script( 'one-author', plugin_dir_url( ONE_AUTHOR_PATH ) . 'one-author/assets/build/js/one-author-min.js', [], filemtime( ONE_AUTHOR_PATH . 'assets\\src\\js\\one-author.js' ), true );
	wp_enqueue_style( 'one-author', plugin_dir_url( ONE_AUTHOR_PATH ) . 'one-author/assets/build/css/one-author-style-min.css', [], filemtime( ONE_AUTHOR_PATH . 'assets\\src\\css\\one-author.css' ) );
	wp_localize_script(
		'one-author',
		'AjaxData',
		[
			'ajax_url'   => admin_url( 'admin-ajax.php' ),
			'ajax_nonce' => wp_create_nonce( 'Admin_demands' ),
		]
	);
}
