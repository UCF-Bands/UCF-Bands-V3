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
class Dynamic_Banner_Shared_Cover {

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
			'knight-blocks/dynamic-banner-shared-cover',
			[
				'render_callback' => [ __CLASS__, 'render' ],
			]
		);

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
	 * @return string  Block HTML.
	 * @since  1.0.0
	 */
	public static function render() {

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
