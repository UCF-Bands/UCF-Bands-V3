<?php
/**
 * Product post type + functionality handler
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
 * Product CPT registration and handling
 *
 * @since 1.0.0
 */
class Products extends Post_Type {

	/**
	 * Post type key
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	const CPT_KEY = 'kb_product';

	/**
	 * Hard-coded shop URL
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	const SHOP_URL = 'https://shop.ucfbands.com';

	/**
	 * Object class to be used for indivudal instances of the post type
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	protected $singular_class = 'Product';

	/**
	 * Flag for global post variable in look
	 *
	 * @since 1.0.0
	 * @var   boolean
	 */
	protected $loop_global_name = 'product';

	/**
	 * Get general post type label
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function get_label() {
		return __( 'Product', 'knight-blocks' );
	}

	/**
	 * Get plural post type label
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function get_plural_label() {
		return __( 'Products', 'knight-blocks' );
	}

	/**
	 * Get non-default post type args
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function get_cpt_args() {
		return [
			'description'         => __( 'Product found on the UCF Marching Knights\' merchandise store', 'knight-blocks' ),
			'labels'              => [
				'archives'              => __( 'Product Archives', 'knight-blocks' ),
				'attributes'            => __( 'Product Attributes', 'knight-blocks' ),
				'parent_item_colon'     => __( 'Parent Product:', 'knight-blocks' ),
				'all_items'             => __( 'All Products', 'knight-blocks' ),
				'add_new_item'          => __( 'Add New Product', 'knight-blocks' ),
				'new_item'              => __( 'New Product', 'knight-blocks' ),
				'edit_item'             => __( 'Edit Product', 'knight-blocks' ),
				'update_item'           => __( 'Update Product', 'knight-blocks' ),
				'view_item'             => __( 'View Product', 'knight-blocks' ),
				'view_items'            => __( 'View Products', 'knight-blocks' ),
				'search_items'          => __( 'Search Product', 'knight-blocks' ),
				'insert_into_item'      => __( 'Insert into product', 'knight-blocks' ),
				'uploaded_to_this_item' => __( 'Uploaded to this product', 'knight-blocks' ),
				'items_list'            => __( 'Products list', 'knight-blocks' ),
				'items_list_navigation' => __( 'Products list navigation', 'knight-blocks' ),
				'filter_items_list'     => __( 'Filter products list', 'knight-blocks' ),
			],
			'supports'            => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
			'public'              => true,
			'show_ui'             => true,
			'menu_icon'           => 'dashicons-tag',
			'show_in_nav_menus'   => false,
			'has_archive'         => 'products',
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'rewrite'             => [
				'slug'       => 'product',
				'with_front' => true,
				'pages'      => true,
				'feeds'      => true,
			],
		];
	}

	/**
	 * Register product meta
	 *
	 * @since 1.0.0
	 */
	public function do_meta_registration() {

		foreach ( [
			'_price'    => 'number',
			'_shop_url' => 'string',
		] as $key => $type ) {
			register_post_meta(
				self::CPT_KEY,
				$key,
				[
					'show_in_rest'  => true,
					'single'        => true,
					'type'          => $type,
					'auth_callback' => 'Knight_Blocks\get_can_user_edit_posts',
				]
			);
		}
	}

	/**
	 * Send product single to shop product or main domain
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function get_singular_redirect() {
		return get_post_meta( get_the_ID(), '_shop_url', true ) ?: esc_url( self::SHOP_URL );
	}

	/**
	 * Send product archive to shop domain
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function get_archive_redirect() {
		return esc_url( self::SHOP_URL );
	}

	/**
	 * Get editor title field placeholder
	 *
	 * @return string
	 * @since  1.0.0
	 */
	protected function get_title_placeholder() {
		return __( 'Enter product name', 'knight-blocks' );
	}

	/**
	 * Manage admin columns
	 *
	 * @param  array $columns Column headings.
	 * @return array $columns
	 *
	 * @since 1.0.0
	 */
	public function set_posts_columns( $columns ) {

		// Move title and date columns.
		$title = $columns['title'] ?? false;
		$date  = $columns['date'] ?? false;
		unset( $columns['title'], $columns['date'] );

		$columns['thumbnail'] = __( 'Image', 'knight-blocks' );

		if ( $title ) {
			$columns['title'] = $title;
		}

		$columns['price']    = __( 'Price', 'knight-blocks' );
		$columns['shop_url'] = __( 'Shop URL', 'knight-blocks' );

		if ( $date ) {
			$columns['date'] = __( 'Date', 'knight-blocks' );
		}

		return $columns;
	}

	/**
	 * Set value of custom admin column
	 *
	 * @param string $name  Column name.
	 * @since 1.0.0
	 */
	public function do_custom_column( $name ) {

		global $kb_product;

		switch ( $name ) {
			case 'thumbnail':
				the_post_thumbnail( [ 100, 100 ] );
				return;

			case 'price':
				$kb_product->do_price();
				return;

			case 'shop_url':
				$kb_product->do_shop_url();
				return;
		}
	}
}
