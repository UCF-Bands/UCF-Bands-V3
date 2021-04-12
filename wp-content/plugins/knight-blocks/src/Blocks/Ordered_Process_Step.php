<?php
/**
 * Ordered process step dynamic block
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
 * Ordered process step block handler
 *
 * @since 1.0.0
 */
class Ordered_Process_Step extends Block {

	/**
	 * Internal block name
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	protected $name = 'ordered-process-step';

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
			'status'      => [
				'type'    => 'string',
				'default' => 'pending',
			],
			'title'       => [
				'type' => 'string',
			],
			'description' => [
				'type'    => 'string',
				'default' => '',
			],
			'type'        => [
				'type'    => 'string',
				'default' => 'static',
			],
			'url'         => [
				'type'    => 'string',
				'default' => '',
			],
		];
	}
}
