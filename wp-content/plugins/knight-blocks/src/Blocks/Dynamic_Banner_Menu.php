<?php
/**
 * Dynamic banner menu dynamic block
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
 * Dynamic banner menu block handler
 *
 * @todo  TRASH THIS!! just keeping fox example sake
 * @since 1.0.0
 */
class Dynamic_Banner_Menu {

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
			'knight-blocks/dynamic-banner-menu',
			[
				'attributes'      => self::get_attributes(),
				'render_callback' => [ __CLASS__, 'render' ],
			]
		);

		register_post_meta(
			'',
			'_dynamic_banner_menu',
			[
				'single'        => true,
				'type'          => 'object',
				'show_in_rest'  => [
					'schema' => [
						'type'       => 'object',
						'properties' => [
							'label' => [ 'type' => 'string' ],
							'value' => [ 'type' => 'number' ],
						],
					],
				],
				'auth_callback' => 'Knight_Blocks\get_can_user_edit_posts',
			]
		);
	}

	/**
	 * Get block attributes
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public static function get_attributes() {

		return [
			'selectedMenu' => [
				'type'    => 'object',
				'default' => [
					'label' => null,
					'value' => null,
				],
			],
		];
	}

	/**
	 * Render block
	 *
	 * @return string  Block HTML.
	 * @since  1.0.0
	 */
	public static function render( $attributes ) {

		// make sure we aren't inheriting a menu from the top-level parent
		$parent = get_current_top_level_parent();

		// grab menu ID from parent, if there is one
		$menu_id = $parent
			? get_post_meta( $parent, '_dynamic_banner_menu', true )
			: $attributes['selectedMenu']['value'];

		if ( empty( $menu_id ) ) {
			return '<span class="no-menu-placeholder"></span>';
		}

		\ob_start();

		wp_nav_menu( [
			'menu'       => $menu_id,
			'menu_class' => 'dynamic-banner-menu',
		] );

		return \ob_get_clean();
	}
}
