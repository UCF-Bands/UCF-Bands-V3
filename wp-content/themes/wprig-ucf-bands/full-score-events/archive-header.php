<?php
/**
 * Template for displaying the events archive header
 *
 * This template can be overridden by copying it to
 * yourtheme/full-score-events/archive-header.php
 *
 * However, Full Score Events may need to update template files and you (the
 * theme developer) will need to copy the new file to your theme to maintain
 * compatibility. It is recommended that you make your customizations using
 * hooks/filters to reduce technical debt.
 *
 * @package Full_Score_Events/templates
 * @since   1.0.0
 */

namespace Full_Score_Events;

global $post_type;

$cover_class = 'wp-block-cover alignfull has-background-dim has-background-gradient is-style-banner';
?>

<header <?php do_attrs_class( 'fse-archive-header', "{$post_type}-archive-header", $cover_class ); ?>>
	<span aria-hidden="true" class="wp-block-cover__gradient-background has-dark-gray-overlay-to-right-gradient-background"></span>
	<?php
	echo wp_get_attachment_image(
		get_theme_mod( 'event_archive_header_background_image' ),
		'full', // @todo get the right image size here
		false,
		[
			'class'           => 'wp-block-cover__image-background',
			'data-object-fit' => 'cover',
		]
	);
	?>
	<div class="wp-block-cover__inner-container">
		<span class="has-text-align-center"><?php get_plugin_template( 'archive-title' ); ?></span>
	</div>
</header>
