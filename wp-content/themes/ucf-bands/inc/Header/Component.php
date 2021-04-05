<?php
/**
 * WP_Rig\WP_Rig\Header\Component class
 *
 * @since   3.0.0
 * @package ucf_bands
 */

namespace WP_Rig\WP_Rig\Header;

use WP_Rig\WP_Rig\Component_Interface;
use WP_Customize_Manager;
use function add_action;

/**
 * Class for managing global header/banner options
 *
 * @since 3.0.0
 */
class Component implements Component_Interface {

	/**
	 * Customizer setting and control ID prefix
	 *
	 * @since 3.0.0
	 * @var   string
	 */
	private $prefix = 'contact';

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @since 3.0.0
	 *
	 * @return string  Component slug.
	 */
	public function get_slug() : string {
		return 'header';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 *
	 * @since 3.0.0
	 */
	public function initialize() {
		add_action( 'customize_register', [ $this, 'action_customize_register' ] );
	}

	/**
	 * Adds a setting and control for lazy loading the Customizer.
	 *
	 * @since 3.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize  Customizer manager instance.
	 */
	public function action_customize_register( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_section(
			'header',
			[
				'title' => __( 'Header', 'ucf-bands' ),
			]
		);

		// Armory "featured link".
		$wp_customize->add_setting( 'ft_link_armory' );
		$wp_customize->add_control(
			'ft_link_armory',
			[
				'section' => 'header',
				'label'   => __( 'Armory Page', 'ucf-bands' ),
				'type'    => 'dropdown-pages',
			]
		);
	}
}
