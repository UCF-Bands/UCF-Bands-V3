<?php
/**
 * Pegasus background dynamic block
 *
 * @todo    Kill this (only here for SVG example)
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
class Pegasus_Background extends Block {

	/**
	 * Internal block name
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	protected $name = 'pegasus-background';

	/**
	 * Render dynamically
	 *
	 * @since 1.0.0
	 * @var   boolean
	 */
	protected $templated = true;

	/**
	 * Render block
	 *
	 * @param  array $attrs Block's attributes.
	 * @return string Block HTML.
	 *
	 * @since  1.0.0
	 */
	public function render( $attrs ) {
		return '<div class="alignwide">' . get_svg( 'pegasus' ) . '</div>';
	}
}
