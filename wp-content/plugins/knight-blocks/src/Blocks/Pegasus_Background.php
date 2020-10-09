<?php
/**
 * Pegasus background dynamic block
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

namespace Knight_Blocks\Blocks;

use function Knight_Blocks\get_svg;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dynamic pegasus background SVG block
 *
 * @since 1.0.0
 */
class Pegasus_Background {

	/**
	 * Set up hooks
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'init', [ __CLASS__, 'do_registration' ] );
	}

	/**
	 * Register block type and associated post meta
	 *
	 * @since 1.0.0
	 */
	public static function do_registration() {

		register_block_type(
			'knight-blocks/pegasus-background',
			[
				'render_callback' => [ __CLASS__, 'render' ],
			]
		);
	}

	/**
	 * Render block
	 *
	 * @return string Block HTML.
	 * @since  1.0.0
	 */
	public static function render() {
		return '<div class="alignwide">' . get_svg( 'pegasus' ) . '</div>';
	}
}
