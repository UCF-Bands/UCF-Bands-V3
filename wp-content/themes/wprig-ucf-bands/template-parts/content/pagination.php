<?php
/**
 * Template part for displaying a pagination
 *
 * @since   3.0.0
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

the_posts_pagination(
	[
		'mid_size'           => 2,
		'prev_text'          => '<i class="fas fa-chevron-left"></i><span class="screen-reader-text">' . _x( 'Previous', 'previous set of search results', 'wp-rig' ) . '</span>',
		'next_text'          => '<i class="fas fa-chevron-right"></i><span class="screen-reader-text">' . _x( 'Next', 'next set of search results', 'wp-rig' ) . '</span>',
		'screen_reader_text' => __( 'Page navigation', 'wp-rig' ),
	]
);
