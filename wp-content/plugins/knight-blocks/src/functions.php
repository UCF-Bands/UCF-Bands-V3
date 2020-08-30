<?php
/**
 * Misc. helpers
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

namespace Knight_Blocks;

/**
 * Wrapper for edit_posts capability check
 *
 * @return bool
 * @since  1.0.0
 */
function get_can_user_edit_posts() {
	return current_user_can( 'edit_posts' );
}
