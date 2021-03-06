<?php
/**
 * Template part for displaying the page content when a 404 error has occurred
 *
 * @since   3.0.0
 * @package ucf_bands
 */

namespace WP_Rig\WP_Rig;

?>
<section class="error">
	<?php get_template_part( 'template-parts/content/page_header' ); ?>

	<div class="page-content">
		<p>
			<?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'ucf-bands' ); ?>
		</p>

		<?php
		get_search_form();

		ucf_bands()->print_styles( 'ucf-bands-widgets' );
		the_widget( 'WP_Widget_Recent_Posts' );
		?>
	</div><!-- .page-content -->
</section><!-- .error -->
