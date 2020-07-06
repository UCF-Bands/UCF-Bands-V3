<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ucf_bands
 */

namespace WP_Rig\WP_Rig;

if ( ! ucf_bands()->is_primary_sidebar_active() ) {
	return;
}

ucf_bands()->print_styles( 'ucf-bands-sidebar', 'ucf-bands-widgets' );

?>
<aside id="secondary" class="primary-sidebar widget-area">
	<?php ucf_bands()->display_primary_sidebar(); ?>
</aside><!-- #secondary -->
