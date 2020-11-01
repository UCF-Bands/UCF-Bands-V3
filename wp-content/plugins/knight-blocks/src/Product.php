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
	 * @return string
	 * @since  1.0.0
	 */
	public function get_price() {
		$price = $this->get( '_price' );

		if ( ! $price ) {
			return false;
		}

		$formatter = new NumberFormatter( 'en_IS', NumberFormatter::CURRENCY );

		return $formatter->formatCurrency( $price, 'USD' );
	}

	/**
	 * Get shop URL
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function get_shop_url() {
		return $this->get( '_shop_url' );
	}
}
