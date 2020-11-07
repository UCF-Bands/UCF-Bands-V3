<?php
/**
 * Base for a dynamically-rendered "selected post" block
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
 * "Selected post" dynamic block functionality
 *
 * @since 1.0.0
 */
class Post {

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

		return [
			'selectedPost' => [
				'type'    => 'object',
				'default' => [
					'label' => 'string',
					'value' => 'string',
				],
			],
		];
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

		// Do sanity check.
		if ( ! $attrs['selectedPost']['value'] ) {
			return '';
		}

		global $post;

		// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$post = $attrs['selectedPost']['value'];
		setup_postdata( $post );

		// Get templates/block/name.php.
		$block = get_block_template( $this->name );

		wp_reset_postdata();

		return $block;
	}
}
