<?php
/**
 * Template part for displaying the header branding
 *
 * @since   3.0.0
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>

<div class="site-branding">

	<a class="site-branding-logo" href="<?php echo esc_url( get_site_url() ); ?>" rel="home">
		<?php wp_rig()->svg( 'logo' ); ?>
		<span class="screen-reader-text"><?php esc_html_e( 'Home', 'wp-rig' ); ?></span>
	</a>

	<p class="site-title screen-reader-text"><?php bloginfo( 'name' ); ?></p>

	<?php
	$wp_rig_description = get_bloginfo( 'description', 'display' );
	if ( $wp_rig_description || is_customize_preview() ) {
		?>
		<p class="site-description screen-reader-text">
			<?php echo $wp_rig_description; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
		</p>
		<?php
	}
	?>
</div><!-- .site-branding -->
