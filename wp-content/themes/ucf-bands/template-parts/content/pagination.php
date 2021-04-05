<?php
/**
 * Template part for displaying a pagination
 *
 * @package ucf_bands
 */

namespace WP_Rig\WP_Rig;

the_posts_pagination(
	[
		'mid_size'           => 2,
		'prev_text'          => '<i class="fas fa-chevron-left"></i><span class="screen-reader-text">' . _x( 'Previous', 'previous set of search results', 'ucf-bands' ) . '</span>',
		'next_text'          => '<i class="fas fa-chevron-right"></i><span class="screen-reader-text">' . _x( 'Next', 'next set of search results', 'ucf-bands' ) . '</span>',
		'screen_reader_text' => __( 'Page navigation', 'ucf-bands' ),
	]
);
