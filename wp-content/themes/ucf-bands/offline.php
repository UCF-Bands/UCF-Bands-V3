<?php
/**
 * The template for displaying offline pages
 *
 * @since 3.0.0
 * @link  https://github.com/xwp/pwa-wp#offline--500-error-handling
 *
 * @package ucf_bands
 */

namespace WP_Rig\WP_Rig;

// Prevent showing nav menus.
add_filter( 'has_nav_menu', '__return_false' );

get_header();

ucf_bands()->print_styles( 'ucf-bands-content' );

?>
	<main id="primary" class="site-main">
		<?php get_template_part( 'template-parts/content/error', 'offline' ); ?>
	</main><!-- #primary -->
<?php
get_footer();
