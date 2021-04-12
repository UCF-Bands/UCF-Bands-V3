<?php
/**
 * Representation for a product
 *
 * This is for a product post in general, not the block.
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

namespace Knight_Blocks;

use NumberFormatter;

// exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Individual product handler
 *
 * @since 1.0.0
 */
class Product extends Post {

	/**
	 * Get formatted price
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_price() {
		$price = $this->get( '_price' );

		if ( ! $price ) {
			return false;
		}

		$formatter = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY );

		return $formatter->formatCurrency( $price, 'USD' );
	}

	/**
	 * Output formatted price
	 *
	 * @since 1.0.0
	 */
	public function do_price() {
		echo esc_html( $this->get_price() );
	}

	/**
	 * Get shop URL
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_shop_url() {
		return $this->get( '_shop_url' );
	}

	/**
	 * Output basic shop URL
	 *
	 * @since 1.0.0
	 */
	public function do_shop_url() {
		$url = $this->get_shop_url();

		if ( ! $url ) {
			return;
		}

		printf(
			'<a href="%1$s" %2$s>%1$s</a>',
			esc_url( $url ),
			is_admin() ? 'rel="nofollow" target="_blank"' : ''
		);
	}
}
