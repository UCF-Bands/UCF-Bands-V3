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
class Ordered_Process_Step extends Templated {

	/**
	 * Set up hooks
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		parent::__construct( 'ordered-process-step' );
	}

	/**
	 * Define block attributes
	 *
	 * @return array
	 * @since  1.0.0
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
				'type' => 'html',
			],
			'type'        => [
				'type'    => 'string',
				'default' => 'static',
			],
			'url'         => [
				'type' => 'string',
			],
		];
	}
}
