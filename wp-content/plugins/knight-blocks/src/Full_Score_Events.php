<?php
/**
 * Full Score Events plugin extensions
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
 * Full Score Events extension handling
 *
 * @since 1.0.0
 */
class Full_Score_Events {

	/**
	 * Hook everything in
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'full_score_events_all_events_link_attributes', [ $this, 'add_icon_link_class' ] );
		add_filter( 'full_score_events_schedule_download_attrs', [ $this, 'add_icon_link_class' ] );
	}

	/**
	 * Add icon link block class to button attributes
	 *
	 * @param  array $attrs  Button attributes.
	 * @return array $attrs
	 *
	 * @since  1.0.0
	 */
	public function add_icon_link_class( $attrs ) {
		$attrs['class'][] = 'wp-block-knight-blocks-icon-link';
		return $attrs;
	}
}
