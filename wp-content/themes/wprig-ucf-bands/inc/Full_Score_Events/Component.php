<?php
/**
 * WP_Rig\WP_Rig\Full_Score_Events\Component class
 *
 * @since   1.0.0
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Full_Score_Events;

use WP_Rig\WP_Rig\Component_Interface;
use function add_filter;
use function add_action;
use function remove_action;
use function \Full_Score_Events\instance as fse;
use function WP_Rig\WP_Rig\wp_rig;

/**
 * Class for Full Score Events adjustments/features
 *
 * @since 1.0.0
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 * @since  1.0.0
	 */
	public function get_slug() : string {
		return 'full_score_events';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 *
	 * @since 1.0.0
	 */
	public function initialize() {

		foreach ( [
			'full_score_events_before_main_content',
			'full_score_events_before_upcoming_events',
		] as $action ) {
			add_action( $action, [ $this, 'do_shared_styles' ] );
		}

		// remove_action( 'customize_register', [ fse()->customizer, 'add_section' ] ); .
	}

	/**
	 * Print global/shared CSS
	 *
	 * @since 1.0.0
	 */
	public function do_shared_styles() {
		wp_rig()->print_styles( 'wp-rig-fse' );
	}
}
