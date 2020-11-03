<?php
/**
 * Side captioned gallery item dynamic block
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

namespace Knight_Blocks\Blocks;

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
		?>
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
