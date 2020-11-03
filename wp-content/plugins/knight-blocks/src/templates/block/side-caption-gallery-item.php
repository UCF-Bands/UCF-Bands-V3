<?php
/**
 * Side-captioned gallery item dynamic block template
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

use function Knight_Blocks\get_allowed_inline_html;

switch ( $type ) {

	case 'video':
		$href  = add_query_arg(
			[
				'rel'            => 0,
				'autoplay'       => 1,
				'controls'       => 1,
				'modestbranding' => 1,
				'fs'             => 0,
				'color'          => 'white',
			],
			$url
		);
		$data  = 'iframe';
		$label = __( 'Play video', 'knight-blocks' );
		break;

	case 'image':
		$href  = '#';
		$data  = wp_get_attachment_image( $thumbID, 'large' );
		$label = __( 'View full image', 'knight-blocks' );
		break;

	case 'image-gallery':
		$href  = $url;
		$data  = false;
		$label = __( 'View gallery', 'knight-blocks' );
		break;

	default:
		break;
}
?>

<figure>
	<?php
	// Output thumbnail.
	if ( $thumbID ) :
		echo wp_get_attachment_image( $thumbID, 'medium_large' );
	else :
		echo '<div class="thumb-placeholder">' . esc_html__( 'Select an image in block settings', 'knight-blocks' ) . '</div>';
	endif;
	?>

	<?php // Output modal or "external" link. ?>
	<a
		href="<?php echo esc_attr( $href ); ?>"
		<?php if ( $data ) : ?>
			data-featherlight="<?php echo esc_attr( $data ); ?>"
		<?php endif; ?>
		<?php if ( 'iframe' === $data ) : ?>
			data-featherlight-iframe-frameborder="0"
			data-featherlight-iframe-allow="autoplay; encrypted-media"
		<?php endif; ?>
	>
		<span class="screen-reader-text"><?php echo esc_html( $label ); ?></span>
	</a>

	<?php
	// Output caption.
	if ( $heading || $caption ) :
		?>
		<figcaption>
			<?php if ( $heading ) : ?>
				<strong class="h3"><?php echo esc_html( $heading ); ?></strong>
			<?php endif; ?>

			<?php if ( $caption ) : ?>
				<p><?php echo wp_kses( $caption, get_allowed_inline_html() ); ?>
			<?php endif; ?>
		</figcaption>
	<?php endif; ?>

</figure>
