<?php
/**
 * Class file: handles the configuration page at admin panel.
 *
 * @package One-Author
 * @author Janak Patel <pateljanak830@gmail.com>
 */

use OneAuthor\Inc\Classes\Admin_Menu;

/**
 * Creates a table on activation of plugin
 *
 * @return void
 */
function create_the_custom_table() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();

	$table_name = $wpdb->prefix . 'one_author';

	$sql = "CREATE TABLE  $table_name ( 
	author_id int NOT NULL,
	author_name varchar(100) NOT NULL,
	author_display_name varchar(20) NOT NULL,
	author_punch_line varchar(255) NOT NULL,
	author_about text NOT NULL,
	author_social_media json NOT NULL,
	author_display_img int NOT NULL,
	author_temp tinyint(1) DEFAULT 1 NOT NULL,
	PRIMARY KEY  (author_id),
	KEY author_name (author_name)
	) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );
}

/**
 * Function that catches the AJAX request validates the data and make sure, data is storable.
 *
 * @return boolean if data is caught or not. return false if it is not a POST request.
 */
function catch_the_data() {
	if ( 'POST' === $_SERVER['REQUEST_METHOD'] ) {
		if ( ! isset( $_POST['dont_copy_the_nonce'] )
			|| ! wp_verify_nonce( $_POST['dont_copy_the_nonce'], 'action_camera_light' )
			) {
			$error = new WP_Error( '001', 'invalid token' );
			wp_send_json_error(
				$error,
				400
			);
			return false;
		}
		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';

		global $admin_menu_instance;
		if ( ! $admin_menu_instance ) {
			$admin_menu_instance = new Admin_Menu();
		}

		$author_id = $admin_menu_instance->is_valid_auth_id( $_POST['one_auth_id'] );
		if ( ! $author_id ) {
			$error = new WP_Error( '002', 'Invalid Author ID' );
			wp_send_json_error(
				$error,
				400
			);
		}

		$author_name = $admin_menu_instance->who_is_author( $author_id );

		$message = [];

		$author_display_name = preg_replace( '/[^a-zA-Z ]/', ' ', $_POST['one_auth_display_name'] );
		$author_display_name = sanitize_text_field( $author_display_name );
		if ( $_POST['one_auth_display_name'] !== $author_display_name ) {
			array_push( $message, sprintf( 'Display name will be stored as "%s", Note that display name is not required to be unique fill free to choose name of your choice', $author_display_name ) );
		}

		$author_punchline = preg_replace( '/[\<>\\/\-]/', ' ', $_POST['one_auth_punch_line'] );
		$author_punchline = sanitize_text_field( $author_punchline );
		if ( $_POST['one_auth_punch_line'] !== $author_punchline ) {
			array_push( $message, sprintf( 'Punch-line will be stored as "%s", avoid special characters', $author_punchline ) );
		}

		$author_about = preg_replace( '/[\<>\\/\-]/', ' ', $_POST['one_auth_description'] );
		$author_about = sanitize_textarea_field( $author_about );
		if ( $_POST['one_auth_description'] !== $author_about ) {
			array_push( $message, sprintf( 'About author will be stored as "%s", avoid special characters', $author_about ) );
		}

		$social_contacts = [
			[
				'handle' => esc_attr( $_POST['one_auth_select_1'] ),
				'url'    => esc_url_raw( $_POST['one_auth_social_1'] ),
			],
			[
				'handle' => esc_attr( $_POST['one_auth_select_2'] ),
				'url'    => esc_url_raw( $_POST['one_auth_social_2'] ),
			],
			[
				'handle' => esc_attr( $_POST['one_auth_select_3'] ),
				'url'    => esc_url_raw( $_POST['one_auth_social_3'] ),
			],
		];

		global $wpdb;
		$table_name = $wpdb->prefix . 'one_author';
		//phpcs:ignore
		$temp_data = $wpdb->get_row( "SELECT * FROM $table_name WHERE author_id = $author_id" );
		if ( ! $temp_data ) {
			$error = new WP_Error( '003', 'Invalid SQL Query' );
			wp_send_json_error(
				$error,
				400
			);
		}
		wp_delete_attachment( (int) $temp_data->author_display_img );

		if ( $wpdb->replace(
			$table_name,
			[
				'author_id'           => $author_id,
				'author_name'         => $author_name,
				'author_display_name' => $author_display_name,
				'author_punch_line'   => $author_punchline,
				'author_about'        => $author_about,
				'author_social_media' => wp_json_encode( $social_contacts ),
				'author_temp'         => 0,
			],
			array( '%d', '%s', '%s', '%s', '%s', '%s', '%d', '%d' ),
		) ) {
			return true;
		} else {
			$error = new WP_Error( '003', 'Invalid SQL Query' );
			wp_send_json_error(
				$error,
				400
			);
		}
	} else {
		return false;
	}
}

/**
 * Returns all the author data, if data exist. Ese returns false.
 *
 * @param integer $auth_id (optional) incase of admin wants to see or change data of others.
 * @return object|false
 */
function fetch_the_data( $auth_id = -1 ) {
	global $admin_menu_instance, $wpdb;

	if ( ! $admin_menu_instance ) {
		$admin_menu_instance = new Admin_Menu();
	}

	if ( 0 <= $auth_id ) {
		$author_id = $admin_menu_instance->is_valid_auth_id( $auth_id );
		if ( ! $author_id ) {
			return false;
		}
	} else {
		if ( current_user_can( 'edit_posts' ) && ! current_user_can( 'manage_options' ) ) {
			$author_id = $admin_menu_instance->current_author->ID;
		} else {
			return false;
		}
	}
	if ( 0 <= $author_id ) {
		$table_name = $wpdb->prefix . 'one_author';
		// phpcs:ignore
		$auth_data = $wpdb->get_row( "SELECT * FROM $table_name WHERE author_id = $author_id" );

		if ( $auth_data ) {
			$auth_data->author_social_media = json_decode( $auth_data->author_social_media, true );
			return $auth_data;
		}
	}
	return false;
}

/**
 * Converts and echo the data of function `fetch_the_data` into JSON to serve AJAX calls
 *
 * @return void
 */
function ajax_data_fetcher() {
	if ( ! check_ajax_referer( 'Admin_demands', 'mini_form_OTW', false ) ) {
		wp_send_json_error( __( 'Invalid security token.', 'one-author' ) );
		wp_die( '0', 400 );
	}

	$data = fetch_the_data( $_POST['one_auth_id'] );
	if ( false !== $data ) {
		$data->success            = true;
		$attachment_url           = wp_get_attachment_url( $data->author_display_img );
		$data->author_display_img = $attachment_url ? wp_get_attachment_url( $data->author_display_img ) : '';
		die( wp_json_encode( $data ) );
	}
	$return_data = [
		'success' => false,
	];
	die( wp_json_encode( $return_data ) );
}

/**
 * Registers the avatar and echo JSON.
 * JSON has
 * 'success' : boolean if registration succeed or not
 * 'url' : url to the attachment
 * 'attachment_id' : id of the attachment.
 *
 * @return void
 */
function mini_form_data_extractor() {
	if ( ! check_ajax_referer( 'Admin_demands', 'mini_form_OTW', false ) ) {
		wp_send_json_error( __( 'Invalid security token.', 'one-author' ) );
		wp_die( '0', 400 );
	}

	$attachment_id = media_handle_upload( 'one_auth_avatar', 0 );

	if ( is_wp_error( $attachment_id ) ) {
		$return_data = [
			'success' => false,
		];
		die( wp_json_encode( $return_data ) );
	} else {
		global $admin_menu_instance, $wpdb;
		$author_id = $admin_menu_instance->is_valid_auth_id( $_POST['one_auth_id'] );
		if ( ! $author_id ) {
			$return_data = [
				'success' => false,
			];
			die( wp_json_encode( $return_data ) );
		}
		$table_name = $wpdb->prefix . 'one_author';

		if ( $wpdb->replace(
			$table_name,
			[
				'author_id'          => $author_id,
				'author_display_img' => $attachment_id,
			],
			array( '%d', '%s' ),
		) ) {
			$return_data = [
				'success'       => true,
				'url'           => wp_get_attachment_url( $attachment_id ),
				'attachment_id' => $attachment_id,
			];
			die( wp_json_encode( $return_data ) );
		} else {
			$return_data = [
				'success' => false,
			];
			die( wp_json_encode( $return_data ) );
		}
	}
}
