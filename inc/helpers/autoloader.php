<?php
/**
 * Helper file: Autoloader.
 *
 * @package One-Author
 * @author Janak Patel <pateljanak830@gmail.com>
 */

namespace OneAuthor\Inc\Helpers;

/**
 * Autoloader converts namespace of the file into actual location of the file and import that file
 *
 * @param string $path : namespace of the file or class.
 * @return void
 */
function autoloader( $path = '' ) {
	$main_namespace = 'OneAuthor';
	if ( empty( $path ) || strpos( $path, '\\' ) === false || strpos( $path, $main_namespace ) !== 0 ) {
		return;
	}

	$path = str_replace( '_', '-', $path );
	$path = explode( '\\', $path );

	$location    = [];
	$location[0] = untrailingslashit( ABSPATH ) . '\\wp-content\\plugins\\one-author';
	$location[1] = strtolower( $path[1] );
	$location[2] = strtolower( $path[2] );

	switch ( $location[2] ) {
		case 'classes':
			$location[3] = 'class-' . strtolower( $path[3] );
			break;
		default:
			$location[3] = strtolower( $path[3] );
			break;
	}
	$resource_locator = implode( '\\', $location );

	require_once $resource_locator . '.php';
}

spl_autoload_register( '\OneAuthor\Inc\Helpers\autoloader' );
