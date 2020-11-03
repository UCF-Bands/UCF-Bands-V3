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

		return [
			'heading'      => [
				'type'    => 'string',
				'default' => __( 'What this thing is', 'knight-blocks' ),
			],
			'caption'      => [
				'type'    => 'string',
				'default' => __( 'Describe the linked media with this caption', 'knight-blocks' ),
			],
			'thumbID'      => [
				'type'    => 'number',
				'default' => 0,
			],
			'thumbPreview' => [
				'type'    => 'string',
				'default' => '',
			],
			'type'         => [
				'type'    => 'string',
				'default' => 'image',
			],
			'url'          => [
				'type'    => 'string',
				'default' => '',
			],
		];
	}
}
