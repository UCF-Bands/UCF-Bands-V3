<?php
/**
 * Side captioned gallery item dynamic block
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

namespace Knight_Blocks\Blocks;

use function Knight_Blocks\get_block_template;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Side captioned gallery item block handler
 *
 * @since 1.0.0
 */
class Side_Caption_Gallery_Item extends Templated {

	/**
	 * Set up hooks
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		parent::__construct( 'side-caption-gallery-item' );
	}

	/**
	 * Define block attributes
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function get_attributes() {

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
