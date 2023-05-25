<?php
/**
 * Class file: handles the configuration page at admin panel.
 *
 * @package One-Author
 * @author Janak Patel <pateljanak830@gmail.com>
 */

namespace OneAuthor\Inc\Classes;

/**
 * Handles the config page.
 */
class Admin_Menu {

	/**
	 * Is current user admin?
	 *
	 * @var boolean
	 */
	public $is_admin_ = false;

	/**
	 * Is current user author only?
	 *
	 * @var boolean
	 */
	public $is_author_ = false;

	/**
	 * Current logged-in author's object.
	 *
	 * @var null|object
	 */
	public $current_author = null;

	/**
	 * Initiates the class.
	 */
	public function __construct() {
		$this->init_hooks();
	}

	/**
	 * Hooks in the page's appearance handler.
	 *
	 * @return void
	 */
	public function init_hooks() {
		add_action( 'admin_menu', [ $this, 'menu_registrar' ] );
	}

	/**
	 * Registers the One Author page at Admin Panel.
	 *
	 * @return void
	 */
	public function menu_registrar() {
		add_menu_page(
			__( 'One Author', 'one-author' ),
			__( 'One Author', 'one-author' ),
			'edit_posts',
			'one-author-page',
			[ $this, 'page_handler' ],
			plugins_url( 'one-author/assets/src/images/inkPen.svg' ),
			99
		);
	}

	/**
	 * One Author page's appearance handler.
	 *
	 * @return void
	 */
	public function page_handler() {
		require_once dirname( __DIR__, 2 ) . '\src\registration-form.php';
	}

	/**
	 * Returns ID and name of users whose role is define as either 'Contributor', 'Editor', 'author' or 'administrator'
	 *
	 * @return array|false
	 */
	public function all_users() {
		$returnable = false;
		// selecting users who can create a post but user in not admin or super-admin.
		if ( current_user_can( 'edit_posts' ) && ! current_user_can( 'manage_options' ) ) {
			$this->is_author_ = true;
			$this->is_admin_  = false;

			$this->current_author = wp_get_current_user();

			$user = $this->current_author;

			$returnable    = null;
			$returnable[0] = [
				'ID'   => $user->ID,
				'name' => $user->user_login,
			];
		} elseif ( current_user_can( 'manage_options' ) ) {
			$this->is_admin_  = true;
			$this->is_author_ = false;

			$this->current_author = wp_get_current_user();

			$args = [
				'role__in' => [
					'Contributor',
					'Author',
					'Editor',
					'Administrator',
				],
				'fields'   => [
					'ID',
					'user_login',
				],
			];

			$users      = get_users( $args );
			$returnable = [];
			foreach ( $users as $sr_no => $user ) {
				$returnable[ $sr_no ] = [
					'ID'   => $user->ID,
					'name' => $user->user_login,
				];
			}
		}

		return $returnable;
	}

	/**
	 * Checks if the given author id is valid author id, and if it has ability to edit posts.
	 *
	 * @param int|string $auth_id : author id which needs to be check.
	 * @return int|false if given id valid, returns author id else returns false.
	 */
	public function is_valid_auth_id( $auth_id ) {
		if ( $auth_id ) {
			$auth_id = preg_replace( '/[^0-9]/', '', $auth_id );
			$auth_id = (string) ( (int) $auth_id ) === (string) $auth_id ? (int) $auth_id : false;
			if ( $auth_id ) {
				if ( user_can( $auth_id, 'edit_posts' ) ) {
					return $auth_id;
				}
			}
		}
		return false;
	}

	/**
	 * Search for the name of the author affiliated with the given author ID.
	 *
	 * @param int $author_id : ID of the author whose name looking for.
	 * @return string|false
	 */
	public function who_is_author( $author_id ) {
		if ( $author_id ) {
			$user = get_user_by( 'id', $author_id );
			if ( $user ) {
				return $user->user_login;
			}
		}
		return false;
	}
}
