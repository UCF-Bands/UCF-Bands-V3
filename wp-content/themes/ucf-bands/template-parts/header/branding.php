<?php
/**
 * Template part for displaying the header branding
 *
 * @since   3.0.0
 * @package ucf_bands
 */

namespace WP_Rig\WP_Rig;

?>

<div class="site-branding">

	<a class="site-branding-logo" href="<?php echo esc_url( get_site_url() ); ?>" rel="home">
		<?php ucf_bands()->svg( 'logo' ); ?>
		<span class="screen-reader-text"><?php esc_html_e( 'Home', 'ucf-bands' ); ?></span>
	</a>

	<p class="site-title screen-reader-text"><?php bloginfo( 'name' ); ?></p>

	<?php
	$ucf_bands_description = get_bloginfo( 'description', 'display' );
	if ( $ucf_bands_description || is_customize_preview() ) {
		?>
		<p class="site-description screen-reader-text">
			<?php echo $ucf_bands_description; /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
		</p>
		<?php
	}
	?>
</div><!-- .site-branding -->
