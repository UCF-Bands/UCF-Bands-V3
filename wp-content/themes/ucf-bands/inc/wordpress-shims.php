<?php
/**
 * Shims for recent WordPress functions
 *
 * @since   3.0.0
 * @package ucf_bands
 */

/**
 * Adds backwards compatibility for wp_body_open() introduced with WordPress 5.2
 *
 * @since 3.0.0
 */
if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Run the wp_body_open action.
	 *
	 * @since 3.0.0
	 *
	 * @return void
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}
