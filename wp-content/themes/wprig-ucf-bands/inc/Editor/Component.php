<?php
/**
 * WP_Rig\WP_Rig\Editor\Component class
 *
 * @since   3.0.0
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Editor;

use WP_Rig\WP_Rig\Component_Interface;
use function add_action;
use function add_theme_support;

/**
 * Class for integrating with the block editor.
 *
 * @since 3.0.0
 * @link  https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
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
		return 'editor';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 *
	 * @since 3.0.0
	 */
	public function initialize() {
		add_action( 'after_setup_theme', [ $this, 'action_add_editor_support' ] );
	}

	/**
	 * Adds support for various editor features.
	 *
	 * @since 3.0.0
	 */
	public function action_add_editor_support() {
		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Add support for default block styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for wide-aligned images.
		add_theme_support( 'align-wide' );

		// Disable support for custom colors.
		add_theme_support( 'disable-custom-colors' );

		/**
		 * Add support for color palettes.
		 *
		 * To preserve color behavior across themes, use these naming conventions:
		 * - Use primary and secondary color for main variations.
		 * - Use `theme-[color-name]` naming standard for standard colors (red, blue, etc).
		 * - Use `custom-[color-name]` for non-standard colors.
		 *
		 * Add the line below to disable the custom color picker in the editor.
		 * add_theme_support( 'disable-custom-colors' );
		 */
		add_theme_support(
			'editor-color-palette',
			[
				[
					'name'  => __( 'Gold', 'wp-rig' ),
					'slug'  => 'gold',
					'color' => '#ffc90a',
				],
				[
					'name'  => __( 'Black', 'wp-rig' ),
					'slug'  => 'black',
					'color' => '#191919',
				],
				[
					'name'  => __( 'Gray', 'wp-rig' ),
					'slug'  => 'gray',
					'color' => '#c1c1c1',
				],
				[
					'name'  => __( 'White', 'wp-rig' ),
					'slug'  => 'white',
					'color' => '#ffffff',
				],
			]
		);

		/**
		 * Add support for gradient presets.
		 */
		add_theme_support(
			'editor-gradient-presets',
			[
				[
					'name'     => __( 'White / Light Gray', 'wp-rig' ),
					'gradient' => 'linear-gradient(90deg, rgb(255, 255, 255) 0%, rgb(244, 244, 244) 100%)',
					'slug'     => 'lightest-gray',
				],
				[
					'name'     => __( 'Light Gray', 'wp-rig' ),
					'gradient' => 'linear-gradient(90deg, rgb(244, 244, 244) 33.333%, rgb(217, 217, 217) 100%)',
					'slug'     => 'light-gray',
				],
				[
					'name'     => __( 'Dark Gray', 'wp-rig' ),
					'gradient' => 'linear-gradient(90deg, rgb(31, 31, 31) 0%, rgb(21, 21, 21) 100%)',
					'slug'     => 'dark-gray',
				],
				[
					'name'     => __( 'Gold', 'wp-rig' ),
					'gradient' => 'linear-gradient(90deg, rgb(255, 201, 10) 0%, rgb(230, 159, 7) 100%)',
					'slug'     => 'gold',
				],
				[
					'name'     => __( 'Dark Gray Overlay (For Images) - Right', 'wp-rig' ),
					'gradient' => 'linear-gradient(135deg, rgba(21, 21, 21, 0.55) 25%, rgb(21, 21, 21) 100%)',
					'slug'     => 'dark-gray-overlay',
				],
				[
					'name'     => __( 'Dark Gray Overlay (For Images) - Left', 'wp-rig' ),
					'gradient' => 'linear-gradient(315deg, rgba(21, 21, 21, 0.55) 0%, rgb(21, 21, 21) 100%)',
					'slug'     => 'dark-gray-overlay-to-right',
				],
			]
		);

		/*
		 * Add support custom font sizes.
		 *
		 * Add the line below to disable the custom color picker in the editor.
		 * add_theme_support( 'disable-custom-font-sizes' );
		 */
		add_theme_support(
			'editor-font-sizes',
			[
				[
					'name'      => __( 'Small', 'wp-rig' ),
					'shortName' => __( 'S', 'wp-rig' ),
					'size'      => 16,
					'slug'      => 'small',
				],
				[
					'name'      => __( 'Medium', 'wp-rig' ),
					'shortName' => __( 'M', 'wp-rig' ),
					'size'      => 25,
					'slug'      => 'medium',
				],
				[
					'name'      => __( 'Large', 'wp-rig' ),
					'shortName' => __( 'L', 'wp-rig' ),
					'size'      => 31,
					'slug'      => 'large',
				],
				[
					'name'      => __( 'Larger', 'wp-rig' ),
					'shortName' => __( 'XL', 'wp-rig' ),
					'size'      => 39,
					'slug'      => 'larger',
				],
			]
		);
	}
}
