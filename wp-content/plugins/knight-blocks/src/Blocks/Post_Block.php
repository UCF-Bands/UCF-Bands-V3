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
class Post_Block extends Block {

	/**
	 * Render dynamically
	 *
	 * @since 1.0.0
	 * @var   boolean
	 */
	protected $templated = true;

	/**
	 * Get block's attributes
	 *
	 * @since 1.0.0
	 *
	 * @return array
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
	 * @since 1.0.0
	 *
	 * @param  array $attrs  Block's attributes.
	 * @return string        Block HTML.
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
