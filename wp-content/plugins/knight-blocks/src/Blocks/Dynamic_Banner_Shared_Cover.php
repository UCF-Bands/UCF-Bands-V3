<?php
/**
 * Dynamic banner shared cover dynamic block
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

namespace Knight_Blocks\Blocks;

use function Knight_Blocks\get_current_top_level_parent;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dynamic banner shared cover block handler
 *
 * @since 1.0.0
 */
class Dynamic_Banner_Shared_Cover extends Block {

	/**
	 * Internal block name
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	protected $name = 'dynamic-banner-shared-cover';

	/**
	 * Render dynamically
	 *
	 * @since 1.0.0
	 * @var   boolean
	 */
	protected $templated = true;

	/**
	 * Do extra meta post meta registration for attribute sourcing
	 *
	 * @since 1.0.0
	 */
	protected function do_meta_registration() {

		register_post_meta(
			'',
			'_dynamic_banner_shared_cover_html',
			[
				'single'        => true,
				'type'          => 'string',
				'show_in_rest'  => true,
				'auth_callback' => 'Knight_Blocks\get_can_user_edit_posts',
			]
		);
	}

	/**
	 * Render block
	 *
	 * @param  array $attrs  Block's attributes.
	 * @return string        Block HTML.
	 *
	 * @since  1.0.0
	 */
	public function render( $attrs ) {

		$cover = get_post_meta(
			get_current_top_level_parent(),
			'_dynamic_banner_shared_cover_html',
			true
		);

		return $cover
			? do_blocks( $cover )
			: '<span class="no-shared-cover-placeholder"></span>';
	}
}
