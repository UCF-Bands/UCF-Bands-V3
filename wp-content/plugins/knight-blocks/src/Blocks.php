<?php
/**
 * Blocks Initializer
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

namespace Knight_Blocks;

// exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Block registration and asset handling
 *
 * @since 1.0.0
 */
class Blocks {

	/**
	 * Shared CSS handle
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	private static $shared_css_handle = 'knight-blocks';

	/**
	 * Shared CSS path
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	private static $shared_css_path = KNIGHT_BLOCKS_URL . 'dist/blocks.style.build.css';

	/**
	 * Spin everything up
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'enqueue_block_editor_assets', [ __CLASS__, 'enqueue_editor_assets' ] );
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_assets' ] );

		// Get dynamic blocks.
		new Blocks\Dynamic_Banner_Menu();
		new Blocks\Dynamic_Banner_Shared_Cover();
	}

	/**
	 * Enqueue editor assets
	 *
	 * @since 1.0.0
	 */
	public static function enqueue_editor_assets() {

		wp_enqueue_script(
			'knight-blocks-blocks',
			KNIGHT_BLOCKS_URL . 'dist/blocks.build.js',
			[
				'wp-blocks',
				'wp-i18n',
				'wp-element',
				'wp-editor',
				'wp-block-editor',
				'wp-components',
				'wp-hooks',
				'wp-data',
				'wp-compose',
				'wp-url',
			],
			KNIGHT_BLOCKS_VERSION,
			true
		);

		// Load shared styles.
		wp_enqueue_style(
			self::$shared_css_handle,
			self::$shared_css_path,
			[ 'wp-editor' ],
			KNIGHT_BLOCKS_VERSION
		);

		// Load editor-only compiled styles.
		wp_enqueue_style(
			'knight-blocks-editor',
			KNIGHT_BLOCKS_URL . 'dist/blocks.editor.build.css',
			[ 'wp-edit-blocks' ],
			KNIGHT_BLOCKS_VERSION
		);

		// Pass in REST URL.
		wp_localize_script(
			'knight-blocks-blocks',
			'knightBlocks',
			[
				'pluginDirPath'  => KNIGHT_BLOCKS_DIR,
				'pluginDirUrl'   => KNIGHT_BLOCKS_URL,
				'topLevelParent' => get_current_top_level_parent(),
			]
		);
	}

	/**
	 * Enqueue frontend assets
	 *
	 * @since 1.0.0
	 */
	public static function enqueue_assets() {

		// Load shared styles.
		wp_enqueue_style(
			self::$shared_css_handle,
			self::$shared_css_path,
			[ 'wp-editor' ],
			KNIGHT_BLOCKS_VERSION
		);

		// Move jQuery to footer.
		wp_scripts()->add_data( 'jquery', 'group', 1 );
		wp_scripts()->add_data( 'jquery-core', 'group', 1 );
		wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );
	}
}
