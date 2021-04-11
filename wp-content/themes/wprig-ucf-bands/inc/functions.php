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
 * Modify the "read more" characters
 *
 * @since 3.0.0
 *
 * @return string  New "read more" text.
 */
function set_excerpt_more() {

	return is_archive() || is_home() ? sprintf(
		'<div class="excerpt-more-wrap">
			<a class="icon-link" href="%s">%s<i class="far fa-long-arrow-alt-right"></i></a>
		</div>',
		get_permalink(),
		__( 'Read more', 'wp-rig' )
	) : sprintf(
		'… <a class="read-more" href="%s"><span>%s</span> <i class="far fa-angle-right"></i></a>',
		get_permalink(),
		__( 'Read', 'wp-rig' )
	);
}
add_filter( 'excerpt_more', __NAMESPACE__ . '\\set_excerpt_more' );
