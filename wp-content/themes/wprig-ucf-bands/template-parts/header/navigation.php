<?php
/**
 * Template part for displaying the header navigation menu
 *
 * @since   3.0.0
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

if ( ! wp_rig()->is_primary_nav_menu_active() ) {
	return;
}

$credits_page = get_theme_mod( 'credits_page' );
?>

<nav id="site-navigation" class="main-navigation nav--toggle-sub nav--toggle-small" aria-label="<?php esc_attr_e( 'Main menu', 'wp-rig' ); ?>"
	<?php
	if ( wp_rig()->is_amp() ) {
		?>
		[class]=" siteNavigationMenu.expanded ? 'main-navigation nav--toggle-sub nav--toggle-small nav--toggled-on' : 'main-navigation nav--toggle-sub nav--toggle-small' "
		<?php
	}
	?>
>
	<?php
	if ( wp_rig()->is_amp() ) {
		?>
		<amp-state id="siteNavigationMenu">
			<script type="application/json">
				{
					"expanded": false
				}
			</script>
		</amp-state>
		<?php
	}
	?>

	<button class="menu-toggle no-wings no-background" aria-label="<?php esc_attr_e( 'Open menu', 'wp-rig' ); ?>" aria-controls="primary-menu-container" aria-expanded="false"
		<?php
		if ( wp_rig()->is_amp() ) {
			?>
			on="tap:AMP.setState( { siteNavigationMenu: { expanded: ! siteNavigationMenu.expanded } } )"
			[aria-expanded]="siteNavigationMenu.expanded ? 'true' : 'false'"
			<?php
		}
		?>
	>
		<span class="menu-toggle-text"><?php esc_html_e( 'Bands', 'wp-rig' ); ?><span class="screen-reader-text"> <?php esc_html_e( 'Menu', 'wp-rig' ); ?></span></span>
		<span class="hamburger"></span>
	</button>

	<div id="primary-menu-container" class="menu-wrap">
		<div class="main-navigation-background">
			<?php wp_rig()->svg( 'pegasus-star' ); ?>
		</div>
		<?php wp_rig()->display_primary_nav_menu( [ 'menu_id' => 'primary-menu' ] ); ?>

		<div class="primary-menu-bottom">
			<?php wp_rig()->address(); ?>

			<?php if ( $credits_page ) : ?>
				<a href="<?php echo esc_url( get_permalink( $credits_page ) ); ?>" class="site-credits-link">
					<?php echo esc_html( get_theme_mod( 'credits_page_link', __( 'Site Credits', 'wp-rig' ) ) ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>

	<div class="menu-cover"></div>

</nav><!-- #site-navigation -->
