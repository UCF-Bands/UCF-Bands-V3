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
		add_action( 'enqueue_block_editor_assets', [ __CLASS__, 'enqueue_shared_assets' ] );
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_assets' ] );
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_shared_assets' ] );

		// add_action( 'init', [ __CLASS__, 'add_patterns' ] );

		// Get dynamic blocks.
		new Blocks\Dynamic_Banner_Menu();
		new Blocks\Dynamic_Banner_Shared_Cover();
		new Blocks\Pegasus_Background();
		new Blocks\Post( 'product' );
		new Blocks\Side_Caption_Gallery_Item();
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
				'wp-edit-post',
				'wp-plugins',
			],
			KNIGHT_BLOCKS_VERSION,
			true
		);

		// Pass in REST URL.
		wp_localize_script(
			'knight-blocks-blocks',
			'knightBlocks',
			apply_filters(
				'knight_blocks_blocks_js_object',
				[
					'pluginDirPath'  => KNIGHT_BLOCKS_DIR,
					'pluginDirUrl'   => KNIGHT_BLOCKS_URL,
					'topLevelParent' => get_current_top_level_parent(),
				]
			)
		);

		// Load editor-only compiled styles.
		wp_enqueue_style(
			'knight-blocks-editor',
			KNIGHT_BLOCKS_URL . 'dist/blocks.editor.build.css',
			[ 'wp-edit-blocks' ],
			KNIGHT_BLOCKS_VERSION
		);
	}

	/**
	 * Enqueue frontend assets
	 *
	 * @since 1.0.0
	 */
	public static function enqueue_assets() {

		// Move jQuery to footer.
		wp_scripts()->add_data( 'jquery', 'group', 1 );
		wp_scripts()->add_data( 'jquery-core', 'group', 1 );
		wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );
	}

	/**
	 * Enqueue assets shared between front end and editor
	 *
	 * @since 1.0.0
	 */
	public static function enqueue_shared_assets() {

		// Load shared styles.
		wp_enqueue_style(
			self::$shared_css_handle,
			self::$shared_css_path,
			[ 'wp-editor', 'featherlight' ],
			KNIGHT_BLOCKS_VERSION
		);

		// Load featherlight (modals) + gallery extension.
		wp_enqueue_script(
			'featherlight',
			'//cdn.jsdelivr.net/npm/featherlight@1.7.14/release/featherlight.min.js',
			[ 'jquery' ],
			'1.7.14',
			true
		);

		wp_enqueue_style(
			'featherlight',
			'//cdn.jsdelivr.net/npm/featherlight@1.7.14/release/featherlight.min.css',
			[],
			'1.7.14'
		);
	}

	/**
	 * Register core/* block patterns
	 *
	 * @todo  Remove this zombie. Unfortunately, the "save" is differing from this.
	 * @since 1.0.0
	 */
	public static function add_patterns() {

		register_block_pattern(
			'knight-blocks/cover-banner',
			[
				'title'       => __( 'Page Banner', 'knight-blocks' ),
				'description' => __( 'Cover block with "Banner" style and gradient background', 'knight-blocks' ),
				// 'keywords'    => [
				// 	__( 'Ok great' ),
				// 	__( 'look at this' ),
				// ],
				// 'content'     => '<!-- wp:cover {\"gradient\":\"dark-gray-overlay-to-right\",\"align\":\"full\",\"className\":\"is-style-banner\"} -->\n<div class=\"wp-block-cover alignfull has-background-dim has-background-gradient is-style-banner\">\n\t<span aria-hidden=\"true\"\n\t\tclass=\"wp-block-cover__gradient-background has-dark-gray-overlay-to-right-gradient-background\"></span>\n\t<div class=\"wp-block-cover__inner-container\">\n\t\t<!-- wp:heading {\"level\":1} -->\n\t\t<h1>Banner Heading</h1>\n\t\t<!-- /wp:heading -->\n\n\t\t<!-- wp:paragraph {\"className\":\"is-style-featured\"} -->\n\t\t<p class=\"is-style-featured\">Director: Mr. Dave Schreier</p>\n\t\t<!-- /wp:paragraph -->\n\t</div>\n</div>\n<!-- /wp:cover -->',
				// 'categories'  => [ 'header' ],
				// 'content' => '<!-- wp:cover {"gradient":"dark-gray-overlay-to-right","align":"full","className":"is-style-banner"} --><div class="wp-block-cover alignfull has-background-dim has-background-gradient is-style-banner">	<span aria-hidden="true"		class="wp-block-cover__gradient-background has-dark-gray-overlay-to-right-gradient-background"></span>	<div class="wp-block-cover__inner-container">		<!-- wp:heading {"level":1} -->		<h1>Banner Heading</h1>		<!-- /wp:heading -->		<!-- wp:paragraph {"className":"is-style-featured"} -->		<p class="is-style-featured">Director: Mr. Dave Schreier</p>		<!-- /wp:paragraph -->	</div></div><!-- /wp:cover -->'
			]
		);
	}
}
