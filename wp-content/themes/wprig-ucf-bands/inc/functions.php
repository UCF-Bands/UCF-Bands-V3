<?php
/**
 * The `wp_rig()` function.
 *
 * @since   3.0.0
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

/**
 * Provides access to all available template tags of the theme.
 *
 * When called for the first time, the function will initialize the theme.
 *
 * @since  3.0.0
 *
 * @return Template_Tags  Template tags instance exposing template tag methods.
 */
function wp_rig() : Template_Tags {
	static $theme = null;

	if ( null === $theme ) {
		$theme = new Theme();
		$theme->initialize();
	}

	return $theme->template_tags();
}

/**
 * Build element attributes from array
 *
 * @since 3.0.0
 *
 * @param  array  $attrs   Attributes (keys) and values.
 * @param  string $prefix  Prefix for data attributes (ex: "data-").
 * @return string          Inline string of data attributes.
 */
function get_attrs( $attrs, $prefix = '' ) {

	// Remove initially empty args.
	$attrs = array_filter( $attrs );

	foreach ( $attrs as $attr => $value ) {

		// data- attributes.
		if ( 'data' === $attr && is_array( $value ) ) {
			$attrs[ $attr ] = get_attrs( array_filter( $value ), 'data-' );
			continue;
		}

		// Array of classes.
		if ( 'class' === $attr && is_array( $value ) ) {
			$value = implode( ' ', array_filter( $value ) );
		}

		// Array of classes + all other cases.
		$attrs[ $attr ] = $prefix . $attr . '="' . esc_attr( $value ) . '"';
	}

	return implode( ' ', $attrs );
}

/**
 * Output HTML string of attributes
 *
 * @since 3.0.0
 *
 * @param  array  $attrs   Attributes and their values.
 * @param  string $prefix  A prefix for data attributes (ex: "data-").
 */
function do_attrs( $attrs, $prefix = '' ) {
	echo get_attrs( $attrs, $prefix ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Modify the "read more" characters
 *
 * @since 3.0.0
 *
 * @return string  New "read more" text.
 */
function set_excerpt_more() {

	// We're manually adding excerpt_more to the entry_summary part.
	return is_archive() || is_home() ?
		''
	: sprintf(
		'… <a class="read-more" href="%s"><span>%s</span> <i class="far fa-angle-right"></i></a>',
		get_permalink(),
		__( 'Read', 'wp-rig' )
	);
}
add_filter( 'excerpt_more', __NAMESPACE__ . '\\set_excerpt_more' );
