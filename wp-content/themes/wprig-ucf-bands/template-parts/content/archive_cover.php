<?php
/**
 * Template part for displaying an archive's "cover" header
 *
 * @since   3.0.0
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$this_post_type = get_post_type();
$image          = get_theme_mod( "{$this_post_type}_archive_header_background_image" );
$subheading     = get_theme_mod( "{$this_post_type}_archive_header_subheading" );
$attrs          = [
	'class' => [
		'wp-block-cover',
		'alignfull',
		'has-background-dim',
		'has-background-gradient',
		'is-style-condensed-banner',
		$image ? null : 'has-dark-gray-gradient-background',
	],
];
?>
<header <?php do_attrs( $attrs ); ?>>
	<?php if ( $image ) : ?>
		<span aria-hidden="true" class="wp-block-cover__gradient-background has-dark-gray-overlay-to-right-gradient-background"></span>
		<?php
	endif;
	echo wp_get_attachment_image(
		$image,
		'knight-blocks-xlarge',
		false,
		[
			'class'           => 'wp-block-cover__image-background',
			'data-object-fit' => 'cover',
		]
	);
	?>
	<div class="wp-block-cover__inner-container">
		<?php if ( is_home() ) : ?>
			<h1 class="page-title">
				<?php single_post_title(); ?>
			</h1>
			<?php
		else :
			the_archive_title( '<h1 class="page-title">', '</h1>' );
		endif;
		if ( $subheading ) :
			?>
			<p class="is-style-featured"><?php echo esc_html( $subheading ); ?></p>
		<?php endif; ?>
	</div>
</header>
