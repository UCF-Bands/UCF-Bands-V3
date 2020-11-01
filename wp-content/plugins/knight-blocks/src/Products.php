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
	 * Hard-coded shop URL
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	const SHOP_DOMAIN = 'shop.ucfbands.com';

	/**
	 * Hook everything in
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'init', [ __CLASS__, 'do_meta_registration' ] );
		add_action( 'template_redirect', [ __CLASS__, 'do_redirect' ] );
		add_action( 'the_post', [ __CLASS__, 'do_post_setup' ] );
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
	 * Redirect products to shopping website
	 *
	 * @since 1.0.0
	 */
	public static function do_redirect() {

		// Send product singles to "shop URL" (main shop as backup).
		if ( is_singular( Plugin::PRODUCT_KEY ) ) {
			$url = get_post_meta( get_the_ID(), '_shop_url', true ) ?: esc_url( self::SHOP_DOMAIN );
			wp_redirect( $url ); // phpcs:ignore WordPress.Security.SafeRedirect
			exit;
		}

		// Send product archive to main shop.
		if ( is_post_type_archive( Plugin::PRODUCT_KEY ) ) {
			wp_redirect( esc_url( self::SHOP_DOMAIN ) ); // phpcs:ignore WordPress.Security.SafeRedirect
			exit;
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
	 * @todo  Move this kind of stuff to a new abstract?
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
