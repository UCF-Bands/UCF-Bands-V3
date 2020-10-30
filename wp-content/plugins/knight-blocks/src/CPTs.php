<?php
/**
 * CPT registration handler
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
 * CPT registration handling
 *
 * @since 1.0.0
 */
class CPTs {

	/**
	 * Hook everything in
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'init', [ __CLASS__, 'do_registration' ] );
		add_action( 'knight_blocks_activate', [ __CLASS__, 'do_registration' ] );
		add_filter( 'enter_title_here', [ __CLASS__, 'set_title_placeholder' ] );
		add_filter( 'knight_blocks_blocks_js_object', [ __CLASS__, 'set_blocks_js_cpts' ] );
	}

	/**
	 * Fire off CPT registrations
	 *
	 * @since 1.0.0
	 */
	public static function do_registration() {
		register_post_type( Plugin::PRODUCT_KEY, self::get_product_args() );
	}

	/**
	 * Get product post type args
	 *
	 * @return array "kb_product" args
	 *
	 * @see   https://generatewp.com/post-type/
	 * @since 1.0.0
	 */
	public static function get_product_args() {

		$labels = [
			'name'                  => _x( 'Products', 'Post Type General Name', 'knight-blocks' ),
			'singular_name'         => _x( 'Product', 'Post Type Singular Name', 'knight-blocks' ),
			'menu_name'             => __( 'Products', 'knight-blocks' ),
			'name_admin_bar'        => __( 'Product', 'knight-blocks' ),
			'archives'              => __( 'Product Archives', 'knight-blocks' ),
			'attributes'            => __( 'Product Attributes', 'knight-blocks' ),
			'parent_item_colon'     => __( 'Parent Product:', 'knight-blocks' ),
			'all_items'             => __( 'All Products', 'knight-blocks' ),
			'add_new_item'          => __( 'Add New Product', 'knight-blocks' ),
			'add_new'               => __( 'Add New', 'knight-blocks' ),
			'new_item'              => __( 'New Product', 'knight-blocks' ),
			'edit_item'             => __( 'Edit Product', 'knight-blocks' ),
			'update_item'           => __( 'Update Product', 'knight-blocks' ),
			'view_item'             => __( 'View Product', 'knight-blocks' ),
			'view_items'            => __( 'View Products', 'knight-blocks' ),
			'search_items'          => __( 'Search Product', 'knight-blocks' ),
			'not_found'             => __( 'Not found', 'knight-blocks' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'knight-blocks' ),
			'featured_image'        => __( 'Product Image', 'knight-blocks' ),
			'set_featured_image'    => __( 'Set product image', 'knight-blocks' ),
			'remove_featured_image' => __( 'Remove product image', 'knight-blocks' ),
			'use_featured_image'    => __( 'Use as product image', 'knight-blocks' ),
			'insert_into_item'      => __( 'Insert into product', 'knight-blocks' ),
			'uploaded_to_this_item' => __( 'Uploaded to this product', 'knight-blocks' ),
			'items_list'            => __( 'Products list', 'knight-blocks' ),
			'items_list_navigation' => __( 'Products list navigation', 'knight-blocks' ),
			'filter_items_list'     => __( 'Filter products list', 'knight-blocks' ),
		];

		return [
			'label'               => __( 'Product', 'knight-blocks' ),
			'description'         => __( 'Product found on the UCF Marching Knights\' merchandise store', 'knight-blocks' ),
			'labels'              => $labels,
			'supports'            => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-tag',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'rewrite'             => false,
			'capability_type'     => 'page',
			'show_in_rest'        => true,
		];
	}

	/**
	 * Set admin "title" field placeholder
	 *
	 * @param  string $title Existing placeholder.
	 * @return string $title New placeholder, if applicable.
	 *
	 * @since 1.0.0
	 */
	public static function set_title_placeholder( $title ) {

		$screen = get_current_screen();

		switch ( $screen->post_type ) {

			case Plugin::PRODUCT_KEY:
				$title = __( 'Enter product name', 'knight-blocks' );
				break;

			default:
				break;
		}

		return $title;
	}

	/**
	 * Set CPT keys that we'll need in the block editor
	 *
	 * @param  array $object Data to be localized in JS object.
	 * @return array $object Data to be localized + CPT keys.
	 *
	 * @since 1.0.0
	 */
	public static function set_blocks_js_cpts( $object ) {

		$object['cpts'] = [
			'product' => Plugin::PRODUCT_KEY,
		];

		return $object;
	}
}
