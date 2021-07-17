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
class Dynamic_Banner_Menu extends Block {

	/**
	 * Internal block name
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	protected $name = 'dynamic-banner-menu';

	/**
	 * Render dynamically
	 *
	 * @since 1.0.0
	 * @var   boolean
	 */
	protected $templated = true;

	/**
	 * Selected menu meta key
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	private static $selected_menu_key = '_dynamic_banner_menu';

	/**
	 * Do extra meta post meta registration for attribute sourcing
	 *
	 * @since 1.0.0
	 */
	protected function do_meta_registration() {

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
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_attributes() {

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
	 * @since 1.0.0
	 *
	 * @param  array $attrs  Block attributes.
	 * @return string        Block HTML.
	 */
	public function render( $attrs ) {

		// Make sure we aren't inheriting a menu from the top-level parent.
		$parent = get_current_top_level_parent();

		// Grab menu ID from parent, if there is one.
		if ( $parent ) {
			$menu_id = get_post_meta( $parent, self::$selected_menu_key, true );
		} else {
			$menu_id = $attrs['selectedMenu']['value']
				? $attrs['selectedMenu']
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
				'container_class' => 'dynamic-banner-menu-container',
				'menu'            => $menu_id,
				'menu_class'      => 'menu dynamic-banner-menu',
			]
		);

		return \ob_get_clean();
	}
}
