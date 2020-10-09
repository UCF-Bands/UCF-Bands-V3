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

	$ancestors = get_post_ancestors( $post );
	return end( $ancestors );
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

/**
 * Get the contents of a SVG
 *
 * @param  string $filename Filename of SVG in /dist/images without .svg.
 * @return string           Contents of SVG file if found.
 *
 * @since  1.0.0
 */
function get_svg( $filename ) {

	$path = KNIGHT_BLOCKS_DIR . "/dist/images/$filename.svg";

	if ( ! file_exists( $path ) ) {
		return '';
	}

	return file_get_contents( $path ); // phpcs:disable
}
