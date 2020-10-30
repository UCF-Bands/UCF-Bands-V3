<?php
/**
 * Product CPT handler
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
 * Product handler class
 *
 * @since 1.0.0
 */
class Products {

	/**
	 * Hook everything in
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'init', [ __CLASS__, 'do_meta_registration' ] );
		// add_action( 'the_post', [ __CLASS__, 'do_post_setup' ] );
	}

	/**
	 * Register product meta
	 *
	 * @since 1.0.0
	 */
	public static function do_meta_registration() {

		foreach ( [
			'_price'    => 'number',
			'_shop_url' => 'string',
		] as $key => $type ) {
			register_post_meta(
				Plugin::PRODUCT_KEY,
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
	 * Set up the global product object
	 *
	 * Inspired by WooCommerce's wc_setup_product_data
	 *
	 * @param  WP_Post $post Post object that is being set up in loop.
	 * @return Product
	 *
	 * @since 1.0.0
	 */
	public static function do_post_setup( $post ) {

		unset( $GLOBALS['knight_blocks_product'] );

		if ( is_int( $post ) ) {
			$post = get_post( $post );
		}

		if ( empty( $post->post_type ) || Plugin::PRODUCT_KEY !== $post->post_type ) {
			return;
		}

		$GLOBALS['knight_blocks_product'] = new Product( $post->ID );

		return $GLOBALS['knight_blocks_product'];
	}
}
