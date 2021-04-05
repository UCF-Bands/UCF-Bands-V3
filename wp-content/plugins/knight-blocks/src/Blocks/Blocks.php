<?php
/**
 * Editor/blocks handler
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

namespace Knight_Blocks\Blocks;

use function Knight_Blocks\get_current_top_level_parent;

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
	 * Block editor CSS/JS asset handle
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	const EDITOR_ASSET_HANDLE = 'knight-blocks-editor';

	/**
	 * Block front end + editor CSS handle
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	const ASSET_HANDLE = 'knight-blocks-blocks';

	/**
	 * Spin everything up
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'init', [ __CLASS__, 'do_asset_registration' ] );
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_assets' ] );
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_shared_assets' ] );
		add_action( 'enqueue_block_editor_assets', [ __CLASS__, 'enqueue_editor_assets' ] );
		add_action( 'enqueue_block_editor_assets', [ __CLASS__, 'enqueue_shared_assets' ] );
		add_action( 'after_setup_theme', [ __CLASS__, 'add_image_sizes' ] );
		add_filter( 'image_size_names_choose', [ __CLASS__, 'add_choosable_image_sizes' ] );

		// add_action( 'init', [ __CLASS__, 'add_patterns' ] );

		// Standard, "native" blocks.
		new Block( 'dynamic-banner' );
		new Block( 'dynamic-banner-addl' );
		new Block( 'cta-card-compact' );
		new Block( 'side-caption-gallery' );
		new Block( 'icon-link' );
		new Block( 'products' );
		new Block( 'icon-and-details' );
		new Block( 'details' );
		new Block( 'ordered-process' );

		// Dynamic/templated blocks.
		new Post_Block( 'product' );
		new Dynamic_Banner_Shared_Cover();
		new Dynamic_Banner_Menu();
		new Pegasus_Background();
		new Side_Caption_Gallery_Item();
		new Ordered_Process_Step();
	}

	/**
	 * Register assets for blocks/editor to use
	 *
	 * @since 1.0.0
	 */
	public static function do_asset_registration() {
		$build_dir = KNIGHT_BLOCKS_DIR . 'build';
		$build_url = KNIGHT_BLOCKS_URL . 'build';
		$asset     = require "$build_dir/editor.asset.php";

		// Register editor JS.
		wp_register_script(
			self::EDITOR_ASSET_HANDLE,
			"$build_url/editor.js",
			$asset['dependencies'],
			$asset['version'],
			true
		);

		// Register editor-specific styles.
		wp_register_style(
			self::EDITOR_ASSET_HANDLE,
			"$build_url/editor.css",
			[ 'wp-edit-blocks', self::ASSET_HANDLE ],
			filemtime( "$build_dir/editor.css" )
		);

		// Register font-end + editor styles.
		wp_register_style(
			self::ASSET_HANDLE,
			"$build_url/style-editor.css",
			[ 'wp-editor', 'featherlight' ],
			filemtime( "$build_dir/style-editor.css" )
		);
	}

	/**
	 * Enqueue editor assets
	 *
	 * @since 1.0.0
	 */
	public static function enqueue_editor_assets() {

		// Always enqueue editor script/styles since we can't register_block our
		// core/* extensions.
		wp_enqueue_script( self::EDITOR_ASSET_HANDLE );
		wp_enqueue_style( self::EDITOR_ASSET_HANDLE );

		// Pass in REST URL.
		wp_localize_script(
			self::EDITOR_ASSET_HANDLE,
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

		// Always enqueue shared styles since we can't register_block our
		// core/* extensions.
		wp_enqueue_style( self::ASSET_HANDLE );

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
	 * Register image sizes needed for blocks
	 *
	 * @since 1.0.0
	 */
	public static function add_image_sizes() {
		add_image_size( 'knight-blocks-xlarge', 1650, 1400, false );
	}

	/**
	 * Add our image sizes to the list of "choosable" image sizes
	 *
	 * This makes the image size available in the MediaUpload "sizes" prop.
	 *
	 * @param  array $sizes  Existing choosable media sizes.
	 * @return array $sizes
	 *
	 * @since  1.0.0
	 */
	public static function add_choosable_image_sizes( $sizes ) {
		$sizes['knight-blocks-xlarge'] = __( 'XLarge', 'knight-blocks' );
		return $sizes;
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
