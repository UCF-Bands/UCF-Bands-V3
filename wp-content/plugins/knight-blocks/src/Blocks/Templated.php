<?php
/**
 * Base for a dynamically-rendered block with dedicated template
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

namespace Knight_Blocks\Blocks;

use function Knight_Blocks\get_block_template;

// exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dynamic block functionality with dedicated render template
 *
 * @since 1.0.0
 */
abstract class Templated {

	/**
	 * Block machine name
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	protected $name;

	/**
	 * Set up props and hooks
	 *
	 * @param string $name Block name (not including knight-blocks/ namespace).
	 * @since 1.0.0
	 */
	public function __construct( $name ) {
		$this->name = $name;
		add_action( 'init', [ $this, 'do_registration' ] );
	}

	/**
	 * Register the block
	 *
	 * @since 1.0.0
	 */
	public function do_registration() {

		register_block_type(
			"knight-blocks/{$this->name}",
			[
				'attributes'      => $this->get_attributes(),
				'render_callback' => [ $this, 'render' ],
			]
		);
	}

	/**
	 * Get block's attributes
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function get_attributes() {
		return [];
	}

	/**
	 * Render the block
	 *
	 * @param  array $attrs Block's attributes.
	 * @return string       Block HTML.
	 *
	 * @since 1.0.0
	 */
	public function render( $attrs ) {
		return get_block_template( $this->name, $attrs );
	}
}
