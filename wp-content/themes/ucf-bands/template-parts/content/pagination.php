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
		'prev_text'          => _x( 'Previous', 'previous set of search results', 'ucf-bands' ),
		'next_text'          => _x( 'Next', 'next set of search results', 'ucf-bands' ),
		'screen_reader_text' => __( 'Page navigation', 'ucf-bands' ),
	]
);
