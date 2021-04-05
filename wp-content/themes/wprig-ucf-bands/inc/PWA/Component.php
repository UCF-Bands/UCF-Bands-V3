<?php
/**
 * WP_Rig\WP_Rig\PWA\Component class
 *
 * @since   3.0.0
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\PWA;

use WP_Rig\WP_Rig\Component_Interface;
use function add_action;
use function add_theme_support;

/**
 * Class for managing PWA support.
 *
 * @since 3.0.0
 * @link  https://wordpress.org/plugins/pwa/
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @since 3.0.0
	 *
	 * @return string  Component slug.
	 */
	public function get_slug() : string {
		return 'pwa';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 *
	 * @since 3.0.0
	 */
	public function initialize() {
		add_action( 'after_setup_theme', [ $this, 'action_add_service_worker_support' ] );
	}

	/**
	 * Adds support for theme-specific service worker integrations.
	 *
	 * @since 3.0.0
	 */
	public function action_add_service_worker_support() {
		add_theme_support( 'service_worker', true );
	}
}
