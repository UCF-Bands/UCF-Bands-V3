<?php
/**
 * Blocks Initializer (zombie for now)
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package User_Role_Adjustments
 */

namespace User_Role_Adjustments;

// exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main block registration and asset handling
 *
 * @since 1.0.0
 */
class Blocks {

	/**
	 * Spin everything up
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'init', [ __CLASS__, 'register_assets' ] );
		add_action( 'enqueue_block_editor_assets', [ __CLASS__, 'enqueue_editor_assets' ] );
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_assets' ] );
	}

	/**
	 * Register assets for frontend and editor
	 *
	 * @since 1.0.0
	 */
	public static function register_assets() {

		// Compiled shared CSS.
		wp_register_style(
			'user-role-adjustments',
			USER_ROLE_ADJUSTMENTS_URL . 'dist/blocks.style.build.css',
			is_admin() ? [ 'wp-editor' ] : null,
			USER_ROLE_ADJUSTMENTS_VERSION
		);
	}

	/**
	 * Enqueue editor assets
	 *
	 * @since 1.0.0
	 */
	public static function enqueue_editor_assets() {

		// Load compiled blocks.
		wp_enqueue_script(
			'user-role-adjustments-blocks',
			USER_ROLE_ADJUSTMENTS_URL . 'dist/blocks.build.js',
			[ 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-block-editor', 'wp-components' ],
			USER_ROLE_ADJUSTMENTS_VERSION,
			true
		);

		// Load shared styles.
		wp_enqueue_style( 'user-role-adjustments' );

		// Load editor-only compiled styles.
		wp_enqueue_style(
			'user-role-adjustments-editor',
			USER_ROLE_ADJUSTMENTS_URL . 'dist/blocks.editor.build.css',
			[ 'wp-edit-blocks' ],
			USER_ROLE_ADJUSTMENTS_VERSION
		);

		// Pass in REST URL.
		wp_localize_script(
			'user-role-adjustments-blocks',
			'userRoleAdjustments',
			[
				'rest_url'      => esc_url( rest_url() ),
				'pluginDirPath' => USER_ROLE_ADJUSTMENTS_DIR,
				'pluginDirUrl'  => USER_ROLE_ADJUSTMENTS_URL,
			]
		);
	}

	/**
	 * Enqueue frontend assets
	 *
	 * @since 1.0.0
	 */
	public static function enqueue_assets() {
		wp_enqueue_style( 'user-role-adjustments' );
	}
}
