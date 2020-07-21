<?php
/**
 * WP_Rig\WP_Rig\Header\Component class
 *
 * @package wp_rig
 * @since   1.0.0
 */

namespace WP_Rig\WP_Rig\Header;

use WP_Rig\WP_Rig\Component_Interface;
use WP_Customize_Manager;
use function WP_Rig\WP_Rig\wp_rig;
use function add_action;

/**
 * Class for managing global header/banner options
 *
 * @since 1.0.0
 */
class Component implements Component_Interface {

	/**
	 * Customizer setting and control ID prefix
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	private $prefix = 'contact';

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'header';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'customize_register', [ $this, 'action_customize_register' ] );
	}

	/**
	 * Adds a setting and control for lazy loading the Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
	 */
	public function action_customize_register( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_section(
			'header',
			[
				'title' => __( 'Header', 'wp-rig' ),
			]
		);

		// Armory "featured link".
		$wp_customize->add_setting( 'ft_link_armory' );
		$wp_customize->add_control(
			'ft_link_armory',
			[
				'section' => 'header',
				'label'   => __( 'Armory Page', 'wp-rig' ),
				'type'    => 'dropdown-pages',
			]
		);
	}
}
