<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @since 3.0.0
 * @link  https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package ucf_bands
 */

namespace WP_Rig\WP_Rig;

get_header();

ucf_bands()->print_styles( 'ucf-bands-content' );

?>
	<main id="primary" class="site-main">
		<?php get_template_part( 'template-parts/content/error', '404' ); ?>
	</main><!-- #primary -->
<?php
get_footer();
