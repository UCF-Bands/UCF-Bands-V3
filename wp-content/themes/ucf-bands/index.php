<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @since 3.0.0
 * @link  https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ucf_bands
 */

namespace WP_Rig\WP_Rig;

get_header();

ucf_bands()->print_styles( 'ucf-bands-content' );

?>
	<main id="primary" class="site-main">
		<?php
		if ( have_posts() ) {

			get_template_part( 'template-parts/content/page_header' );

			while ( have_posts() ) {
				the_post();

				get_template_part( 'template-parts/content/entry_loop', get_post_type() );
			}

			get_template_part( 'template-parts/content/pagination' );

		} else {
			get_template_part( 'template-parts/content/error' );
		}
		?>
	</main><!-- #primary -->
<?php
get_sidebar();
get_footer();
