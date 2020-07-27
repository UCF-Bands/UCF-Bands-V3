<?php
/**
 * Template part for displaying the header navigation menu
 *
 * @package ucf_bands
 */

namespace WP_Rig\WP_Rig;

if ( ! ucf_bands()->is_primary_nav_menu_active() ) {
	return;
}

?>

<nav id="site-navigation" class="main-navigation nav--toggle-sub nav--toggle-small" aria-label="<?php esc_attr_e( 'Main menu', 'ucf-bands' ); ?>"
	<?php
	if ( ucf_bands()->is_amp() ) {
		?>
		[class]=" siteNavigationMenu.expanded ? 'main-navigation nav--toggle-sub nav--toggle-small nav--toggled-on' : 'main-navigation nav--toggle-sub nav--toggle-small' "
		<?php
	}
	?>
>
	<?php
	if ( ucf_bands()->is_amp() ) {
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

	<button class="menu-toggle no-wings no-background" aria-label="<?php esc_attr_e( 'Open menu', 'ucf-bands' ); ?>" aria-controls="primary-menu-container" aria-expanded="false"
		<?php
		if ( ucf_bands()->is_amp() ) {
			?>
			on="tap:AMP.setState( { siteNavigationMenu: { expanded: ! siteNavigationMenu.expanded } } )"
			[aria-expanded]="siteNavigationMenu.expanded ? 'true' : 'false'"
			<?php
		}
		?>
	>
		<span class="menu-toggle-text"><?php esc_html_e( 'Bands', 'ucf-bands' ); ?><span class="screen-reader-text"> <?php esc_html_e( 'Menu', 'ucf-bands' ); ?></span></span>
		<span class="hamburger"></span>
	</button>

	<div id="primary-menu-container" class="menu-wrap">
		<div class="main-navigation-background">
			<?php ucf_bands()->svg( 'pegasus-star' ); ?>
		</div>
		<?php ucf_bands()->display_primary_nav_menu( [ 'menu_id' => 'primary-menu' ] ); ?>
		<?php ucf_bands()->address(); ?>
	</div>

	<div class="menu-cover"></div>

</nav><!-- #site-navigation -->
