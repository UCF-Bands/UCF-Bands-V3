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
class Side_Caption_Gallery_Item extends Block {

	/**
	 * Internal block name
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	protected $name = 'side-caption-gallery-item';

	/**
	 * Render dynamically
	 *
	 * @since 1.0.0
	 * @var   boolean
	 */
	protected $templated = true;

	/**
	 * Define block attributes
	 *
	 * @since 1.0.0
	 *
	 * @return array
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
