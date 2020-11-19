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
		$label = __( 'Video', 'knight-blocks' );
		$icon  = 'film';
		break;

	case 'image':
		$href  = '#';
		$data  = wp_get_attachment_image( $thumbID, 'large' );
		$label = __( 'Image', 'knight-blocks' );
		$icon  = false;
		break;

	case 'image-gallery':
		$href  = $url;
		$data  = false;
		$label = __( 'Gallery', 'knight-blocks' );
		$icon  = 'images';
		break;

	default:
		break;
}

$loader = sprintf(
	'<div class="featherlight-loader"><span class="screen-reader-text">%s</span></div>',
	__( 'Loading', 'knight-blocks' )
);
?>

<figure class="<?php echo $thumbID ? '' : 'no-thumb'; ?>">
	<?php
	if ( $thumbID ) :
		echo wp_get_attachment_image( $thumbID, 'medium_large', false, [ 'class' => 'skip-lazy' ] );
	else :
		echo '<div class="thumb-placeholder">' . esc_html__( 'Select an image in block settings', 'knight-blocks' ) . '</div>';
	endif;
	?>

	<a
		href="<?php echo esc_url_raw( $href ); ?>"
		<?php if ( $data ) : ?>
			data-featherlight-root=".site, .editor-styles-wrapper"
			data-featherlight="<?php echo esc_attr( $data ); ?>"
			data-featherlight-variant="featherlight-<?php echo esc_attr( $type ); ?>"
			data-featherlight-loading="<?php echo esc_attr( $loader ); ?>"
		<?php endif; ?>
		<?php if ( 'iframe' === $data ) : ?>
			data-featherlight-iframe-frameborder="0"
			data-featherlight-iframe-allow="autoplay; encrypted-media"
		<?php endif; ?>
	>
		<?php
		/* translators: View %s */
		printf( esc_html__( 'View %s', 'knight-blocks' ), esc_html( $label ) );
		?>
	</a>

	<?php if ( $heading || $caption ) : ?>
		<figcaption>
			<?php if ( $icon ) : ?>
				<span class="type-label"><?php echo esc_html( $label ); ?></span>
			<?php endif; ?>

			<?php if ( $heading ) : ?>
				<strong class="h5 has-underline"><?php echo esc_html( $heading ); ?></strong>
			<?php endif; ?>

			<?php if ( $caption ) : ?>
				<p><?php echo wp_kses( $caption, get_allowed_inline_html() ); ?></p>
			<?php endif; ?>
		</figcaption>
	<?php endif; ?>

	<?php if ( $icon ) : ?>
		<span class="type-icon">
			<i class="far fa-<?php echo esc_attr( $icon ); ?>"></i>
		</span>
	<?php endif; ?>

</figure>
