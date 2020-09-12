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
	 * Selected menu meta key
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	private static $selected_menu_key = '_dynamic_banner_menu';

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
			self::$selected_menu_key,
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
	 * @param  array $attributes Block attributes.
	 * @return string             Block HTML.
	 *
	 * @since  1.0.0
	 */
	public static function render( $attributes ) {

		// Make sure we aren't inheriting a menu from the top-level parent.
		$parent = get_current_top_level_parent();

		// Grab menu ID from parent, if there is one.
		if ( $parent ) {
			$menu_id = get_post_meta( $parent, self::$selected_menu_key, true );
		} else {
			$menu_id = $attributes['selectedMenu']['value']
				? $attributes['selectedMenu']
				: get_post_meta( get_the_ID(), self::$selected_menu_key, true );
		}

		// We want the "value": the menu ID.
		$menu_id = $menu_id['value'] ?? false;

		if ( empty( $menu_id ) ) {
			return '<span class="no-menu-placeholder"></span>';
		}

		\ob_start();

		wp_nav_menu(
			[
				'menu'       => $menu_id,
				'menu_class' => 'dynamic-banner-menu',
			]
		);

		return \ob_get_clean();
	}
}
