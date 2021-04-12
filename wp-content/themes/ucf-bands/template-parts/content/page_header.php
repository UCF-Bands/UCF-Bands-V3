<?php
/**
 * Template part for displaying the page header of the currently displayed page
 *
 * @since   3.0.0
 * @package ucf_bands
 */

namespace WP_Rig\WP_Rig;

if ( is_404() ) {
	?>
	<header class="page-header">
		<h1 class="page-title">
			<?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'ucf-bands' ); ?>
		</h1>
	</header>
	<?php
} elseif ( is_home() && ! have_posts() ) {
	?>
	<header class="page-header">
		<h1 class="page-title">
			<?php esc_html_e( 'Nothing Found', 'ucf-bands' ); ?>
		</h1>
	</header>
	<?php
} elseif ( is_home() && ! is_front_page() ) {
	get_template_part( 'template-parts/content/archive_cover' );
} elseif ( is_search() ) {
	?>
	<header class="page-header">
		<h1 class="page-title">
			<?php
			printf(
				/* translators: %s: search query */
				esc_html__( 'Search Results for: %s', 'ucf-bands' ),
				'<span>' . get_search_query() . '</span>'
			);
			?>
		</h1>
	</header>
	<?php
} elseif ( is_archive() ) {
	get_template_part( 'template-parts/content/archive_cover' );
}
