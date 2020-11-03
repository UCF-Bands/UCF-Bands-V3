<?php
/**
 * Side captioned gallery item dynamic block
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

namespace Knight_Blocks\Blocks;

use function Knight_Blocks\get_allowed_inline_html;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Side captioned gallery item block handler
 *
 * @since 1.0.0
 */
class Side_Caption_Gallery_Item {

	/**
	 * Set up hooks
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'init', [ __CLASS__, 'do_registration' ] );
	}

	/**
	 * Register block type
	 *
	 * @since 1.0.0
	 */
	public static function do_registration() {

		register_block_type(
			'knight-blocks/side-caption-gallery-item',
			[
				'attributes'      => self::get_attributes(),
				'render_callback' => [ __CLASS__, 'render' ],
			]
		);
	}

	/**
	 * Render block
	 *
	 * @param  array $attrs Block attributes.
	 * @return string       Block HTML.
	 *
	 * @since  1.0.0
	 */
	public static function render( $attrs ) {

		\ob_start();
		var_dump( $attrs );

		switch ( $attrs['type'] ) {

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
					$attrs['url']
				);
				$data  = 'iframe';
				$label = __( 'Play video', 'knight-blocks' );
				break;

			case 'image':
				$href  = '#';
				$data  = wp_get_attachment_image( $attrs['thumbID'], 'large' );
				$label = __( 'View full image', 'knight-blocks' );
				break;

			case 'image-gallery':
				$href  = $attrs['url'];
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
			if ( $attrs['thumbID'] ) :
				echo wp_get_attachment_image( $attrs['thumbID'], 'medium_large' );
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
			if ( $attrs['heading'] || $attrs['caption'] ) :
				?>
				<figcaption>
					<?php if ( $attrs['heading'] ) : ?>
						<strong class="h3"><?php echo esc_html( $attrs['heading'] ); ?></strong>
					<?php endif; ?>

					<?php if ( $attrs['caption'] ) : ?>
						<p><?php echo wp_kses( $attrs['caption'], get_allowed_inline_html() ); ?>
					<?php endif; ?>
				</figcaption>
			<?php endif; ?>

		</figure>
		<?php
		return \ob_get_clean();
	}

	/**
	 * Define block attributes
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public static function get_attributes() {

		$attrs = [];

		foreach ( [
			'heading',
			'caption',
			'thumbPreview',
			'type',
			'url',
		] as $attr ) {
			$attrs[ $attr ] = [ 'type' => 'string' ];
		}

		$attrs['thumbID'] = [ 'type' => 'number' ];

		return $attrs;
	}
}
