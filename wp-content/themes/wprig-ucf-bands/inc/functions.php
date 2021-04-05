<?php
/**
 * The `wp_rig()` function.
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

/**
 * Provides access to all available template tags of the theme.
 *
 * When called for the first time, the function will initialize the theme.
 *
 * @return Template_Tags Template tags instance exposing template tag methods.
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
 * Modify the "read more" characters
 *
 * @return string New "read more" text.
 * @since  3.0.0
 */
function set_excerpt_more() {
	return sprintf(
		'… <a class="read-more" href="%s"><span>%s</span> <i class="far fa-angle-right"></i></a>',
		get_permalink(),
		__( 'Read', 'wp-rig' )
	);
}
add_filter( 'excerpt_more', __NAMESPACE__ . '\\set_excerpt_more' );
