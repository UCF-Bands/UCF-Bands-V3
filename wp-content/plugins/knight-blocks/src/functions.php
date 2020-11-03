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

/**
 * Get a plugin template
 *
 * @param string $name Template part name (excluding .php).
 * @param array  $args Template arguments (extracted to vars).
 *
 * @since 1.0.0
 */
function get_plugin_template( $name, $args = [] ) {

	// Maker vars for all the args.
	if ( ! empty( $args ) && is_array( $args ) ) {
		extract( $args );
	}

	// Set the path and ensure the template is there.
	$template = KNIGHT_BLOCKS_DIR . "src/templates/{$name}.php";

	if ( ! file_exists( $template ) ) {
		return;
	}

	// Load the template part.
	include $template;
}

/**
 * Custom kses allowed HTML for "inlined" entities.
 *
 * @return array Allowed HTML entities/attributes.
 * @since  1.0.0
 */
function get_allowed_inline_html() {
	return [
		'a'      => [
			'href'  => [],
			'rel'   => [],
			'title' => [],
		],
		'b'      => [],
		'strong' => [],
		'i'      => [],
		'em'     => [],
		'code'   => [],
	];
}

/**
 * Configure "allowed inline HTML" message for block editor.
 *
 * @param  array $object Data to be localized in JS object.
 * @return array $object Data to be localized + "allowed inline HTML" help text.
 *
 * @since  1.0.0
 */
function set_blocks_js_allowed_inline_html_help( $object ) {

	$object['allowedInlineHTML'] = sprintf(
		__( 'Allowed HTML: %s', 'knight-blocks' ),
		implode( ', ', array_keys( get_allowed_inline_html() ) )
	);

	return $object;
}
add_filter( 'knight_blocks_blocks_js_object', __NAMESPACE__ . '\set_blocks_js_allowed_inline_html_help' );
