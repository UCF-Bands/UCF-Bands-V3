<?php
/**
 * Misc. helpers
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

namespace Knight_Blocks;

/**
 * Get current top-level parent post ID
 *
 * @return integer
 * @since  1.0.0
 */
function get_current_top_level_parent() {
	global $post;

	if ( ! $post->post_parent ) {
		return 0;
	}

	return end( get_post_ancestors( $post ) );
}

/**
 * Wrapper for edit_posts capability check
 *
 * @return bool
 * @since  1.0.0
 */
function get_can_user_edit_posts() {
	return current_user_can( 'edit_posts' );
}
