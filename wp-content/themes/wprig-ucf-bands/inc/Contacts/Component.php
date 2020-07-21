<?php
/**
 * WP_Rig\WP_Rig\Contacts\Component class
 *
 * @package wp_rig
 * @since   1.0.0
 */

namespace WP_Rig\WP_Rig\Contacts;

use WP_Rig\WP_Rig\Component_Interface;
use WP_Customize_Manager;
use function WP_Rig\WP_Rig\wp_rig;
use function add_action;

/**
 * Class for managing global header and footer options/fields/interaction
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
		return 'contacts';
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
			'contacts',
			[
				'title' => __( 'Contact Information', 'wp-rig' ),
			]
		);

		$fields = [
			'phone'         => [
				'label'       => __( 'Phone Number', 'wp-rig' ),
				'description' => __( 'For tel: links. Do not include +1-.', 'wp-rig' ),
			],
			'phone_display' => [
				'label'       => __( 'Phone Display', 'wp-rig' ),
				'description' => __( 'Number displayed to visitors. Ex: (407) 823-0000.', 'wp-rig' ),
			],
			'fax'           => [
				'label'       => __( 'Fax', 'wp-rig' ),
				'description' => __( 'Uhoh', 'wp-rig' ),
			],
			'email'         => [
				'label'       => __( 'Email', 'wp-rig' ),
			],
			'addr_1'        => [
				'label'       => __( 'Address Line 1', 'wp-rig' ),
				'description' => __( 'Ex: UCF Bands', 'wp-rig' ),
			],
			'addr_2'        => [
				'label'       => __( 'Address Line 2', 'wp-rig' ),
				'description' => __( 'Ex: Department of Music', 'wp-rig' ),
			],
			'addr_3'        => [
				'label'       => __( 'Address Line 3', 'wp-rig' ),
				'description' => __( 'Ex: 12488 Centaurus Blvd.', 'wp-rig' ),
			],
			'addr_4'        => [
				'label'       => __( 'City, State, Zip', 'wp-rig' ),
			],
		];

		foreach ( $fields as $key => $args ) {

			$wp_customize->add_setting( "{$this->prefix}_$key" );

			$wp_customize->add_control(
				"{$this->prefix}_$key",
				wp_parse_args(
					$args,
					[
						'label'       => $key,
						'description' => '',
						'section'     => 'contacts',
						'type'        => 'text',
					]
				)
			);
		}
	}
}
