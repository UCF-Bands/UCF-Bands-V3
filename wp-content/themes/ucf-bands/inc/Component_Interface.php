<?php
/**
 * WP_Rig\WP_Rig\Component_Interface interface
 *
 * @since   3.0.0
 * @package ucf_bands
 */

namespace WP_Rig\WP_Rig;

/**
 * Interface for a theme component.
 *
 * @since 3.0.0
 */
interface Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @since 3.0.0
	 *
	 * @return string  Component slug.
	 */
	public function get_slug() : string;

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 *
	 * @since 3.0.0
	 */
	public function initialize();
}
