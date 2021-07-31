<?php
/**
 * Misc. helper functions
 *
 * @since   1.0.0
 * @package User_Role_Adjustments
 */

namespace User_Role_Adjustments;

/**
 * Returns a $_GET value
 *
 * @param  string  $key  $_GET superglobal key.
 * @return mixed
 * @see    https://github.com/WordPress/WordPress-Coding-Standards/wiki/Fixing-errors-for-input-data
 * @since  1.0.0
 */
function get( $key ) {
	return isset( $_GET[ $key ] ) ? sanitize_text_field( wp_unslash( $_GET[ $key ] ) ) : null;
}
