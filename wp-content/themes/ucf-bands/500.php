<?php
/**
 * The template for displaying 500 pages (internal server errors)
 *
 * @link https://github.com/xwp/pwa-wp#offline--500-error-handling
 *
 * @package ucf_bands
 */

namespace WP_Rig\WP_Rig;

get_header();

ucf_bands()->print_styles( 'ucf-bands-content' );

?>
	<main id="primary" class="site-main">
		<?php get_template_part( 'template-parts/content/error', '500' ); ?>
	</main><!-- #primary -->
<?php
get_footer();
