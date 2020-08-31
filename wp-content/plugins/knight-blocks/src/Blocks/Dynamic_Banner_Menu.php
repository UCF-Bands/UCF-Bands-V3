<?php
/**
 * Dynamic banner menu dynamic block
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

namespace Knight_Blocks\Blocks;

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
				// 'attributes'      => self::get_attributes(),
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

	// /**
	//  * Get block attributes
	//  *
	//  * @return array
	//  * @since  1.0.0
	//  */
	// public static function get_attributes() {

	// 	return [
	// 		'selectedMenu' => [
	// 			'type'    => 'object',
	// 			'default' => [
	// 				'label' => 'string',
	// 				'value' => 'string',
	// 			],
	// 		],
	// 	];
	// }

	/**
	 * Render block
	 *
	 * @return string  Block HTML.
	 * @since  1.0.0
	 */
	public static function render( $attributes ) {

		\ob_start();
		\d( $attributes );
		?>

		<p><?php esc_html_e( 'Ok this is dynamic bro', 'knight-blocks' ); ?></p>

		<?php
		return \ob_get_clean();
	}
}
