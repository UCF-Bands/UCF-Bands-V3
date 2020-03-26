<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register assets for frontend and editor
 *
 * @since 1.0.0
 */
function knight_blocks_register_assets() {

	// compiled shared CSS
	wp_register_style(
		'knight-blocks',
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ),
		is_admin() ? [ 'wp-editor' ] : null,
		KNIGHT_BLOCKS_VERSION
	);
}
add_action( 'init', 'knight_blocks_register_assets' );

/**
 * Enqueue editor assets
 *
 * @since 1.0.0
 */
function knight_blocks_editor_assets() {

	// load compiled blocks
	wp_enqueue_script(
		'knight-blocks-blocks',
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), // blocks.build.js: We register the block here. Built with Webpack.
		[ 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ],
		KNIGHT_BLOCKS_VERSION,
		true
	);

	// load shared styles
	wp_enqueue_style( 'knight-blocks' );

	// load editor-only compiled styles
	wp_enqueue_style(
		'knight-blocks-editor',
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ),
		[ 'wp-edit-blocks' ],
		KNIGHT_BLOCKS_VERSION
	);

	// pass in REST URL
	wp_localize_script(
		'knight-blocks-blocks',
		'knightBlocks',
		[
			'rest_url'      => esc_url( rest_url() ),
			'pluginDirPath' => plugin_dir_path( __DIR__ ),
			'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
		]
	);
}
add_action( 'enqueue_block_editor_assets', 'knight_blocks_editor_assets' );

/**
 * Enqueue frontend assets
 *
 * @since 1.0.0
 */
function knight_blocks_assets() {
	wp_enqueue_style( 'knight-blocks' );
}
add_action( 'wp_enqueue_scripts', 'knight_blocks_assets' );
