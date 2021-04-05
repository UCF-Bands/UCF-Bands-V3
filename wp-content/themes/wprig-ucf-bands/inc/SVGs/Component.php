<?php
/**
 * WP_Rig\WP_Rig\SVG\Component class
 *
 * @since   3.0.0
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\SVGs;

use WP_Rig\WP_Rig\Component_Interface;
use WP_Rig\WP_Rig\Templating_Component_Interface;
use function esc_html__;

/**
 * Class for SVG handling/helpers
 *
 * Exposes template tags:
 * * `wp_rig()->get_svg( string $image )`
 * * `wp_rig()->svg( string $image )`
 *
 * @since 3.0.0
 */
class Component implements Component_Interface, Templating_Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @since 3.0.0
	 *
	 * @return string  Component slug.
	 */
	public function get_slug() : string {
		return 'svgs';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 *
	 * @since 3.0.0
	 */
	public function initialize() {
	}

	/**
	 * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `wp_rig()`.
	 *
	 * @since 3.0.0
	 *
	 * @return array  Associative array of $method_name => $callback_info pairs. Each $callback_info must either be
	 *                a callable or an array with key 'callable'. This approach is used to reserve the possibility of
	 *                adding support for further arguments in the future.
	 */
	public function template_tags() : array {
		return [
			'get_svg' => [ $this, 'get_svg' ],
			'svg'     => [ $this, 'svg' ],
		];
	}

	/**
	 * Get the string of an SVG for inlining
	 *
	 * @since  3.0.0
	 *
	 * @param  string $image  File name for image in assets/images, without ".svg".
	 * @return string         Contents of svg.
	 */
	public function get_svg( string $image ) : string {

		$path = get_theme_file_path( "assets/images/{$image}.svg" );

		// Make sure something is there.
		if ( ! file_exists( $path ) ) {
			return '';
		}

		// Get the file contents.
		ob_start();
		include $path;
		return "<div class='svg svg-{$image}'>" . ob_get_clean() . '</div>';
	}

	/**
	 * Output an inlined SVG
	 *
	 * @since 3.0.0
	 *
	 * @param string $image  File name for image in assets/images, without ".svg".
	 */
	public function svg( string $image ) {
		echo $this->get_svg( $image ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
