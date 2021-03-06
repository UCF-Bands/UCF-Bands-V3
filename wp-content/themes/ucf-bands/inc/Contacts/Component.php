<?php
/**
 * WP_Rig\WP_Rig\Contacts\Component class
 *
 * @since   3.0.0
 * @package ucf_bands
 */

namespace WP_Rig\WP_Rig\Contacts;

use WP_Rig\WP_Rig\Component_Interface;
use WP_Rig\WP_Rig\Templating_Component_Interface;
use WP_Customize_Manager;
use function WP_Rig\WP_Rig\ucf_bands;
use function add_action;
use function add_filter;
use function apply_filters;
use function get_theme_mod;
use function wp_parse_args;

/**
 * Class for managing global contact information
 *
 * @since 3.0.0
 */
class Component implements Component_Interface, Templating_Component_Interface {

	/**
	 * Customizer setting and control ID prefix
	 *
	 * @since 3.0.0
	 * @var   string
	 */
	private $prefix = 'contact';

	/**
	 * Theme mod cache
	 *
	 * @since 3.0.0
	 * @var   array
	 */
	private $contacts = [];

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @since 3.0.0
	 *
	 * @return string  Component slug.
	 */
	public function get_slug() : string {
		return 'contacts';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 *
	 * @since 3.0.0
	 */
	public function initialize() {
		add_action( 'customize_register', [ $this, 'action_customize_register' ] );
		add_filter( 'ucf_bands_get_contact_phone', 'esc_attr' );
		add_filter( 'ucf_bands_get_contact_email', 'sanitize_email' );
	}

	/**
	 * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `ucf_bands()`.
	 *
	 * @since 3.0.0
	 *
	 * @return array  Associative array of $method_name => $callback_info pairs. Each $callback_info must either be
	 *                a callable or an array with key 'callable'. This approach is used to reserve the possibility of
	 *                adding support for further arguments in the future.
	 */
	public function template_tags() : array {
		return [
			'get_contact' => [ $this, 'get_contact' ],
			'get_address' => [ $this, 'get_address' ],
			'address'     => [ $this, 'do_address' ],
		];
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
			'contacts',
			[
				'title' => __( 'Contact Information', 'ucf-bands' ),
			]
		);

		$fields = [
			'phone'         => [
				'label'       => __( 'Phone Number', 'ucf-bands' ),
				'description' => __( 'For tel: links. Do not include +1-.', 'ucf-bands' ),
			],
			'phone_display' => [
				'label'       => __( 'Phone Display', 'ucf-bands' ),
				'description' => __( 'Number displayed to visitors. Ex: (407) 823-0000.', 'ucf-bands' ),
			],
			'fax'           => [
				'label'       => __( 'Fax', 'ucf-bands' ),
				'description' => __( 'Uhoh', 'ucf-bands' ),
			],
			'email'         => [
				'label'       => __( 'Email', 'ucf-bands' ),
			],
			'addr_1'        => [
				'label'       => __( 'Address Line 1', 'ucf-bands' ),
				'description' => __( 'Ex: UCF Bands', 'ucf-bands' ),
			],
			'addr_2'        => [
				'label'       => __( 'Address Line 2', 'ucf-bands' ),
				'description' => __( 'Ex: Department of Music', 'ucf-bands' ),
			],
			'addr_3'        => [
				'label'       => __( 'Address Line 3', 'ucf-bands' ),
				'description' => __( 'Ex: 12488 Centaurus Blvd.', 'ucf-bands' ),
			],
			'addr_4'        => [
				'label'       => __( 'City, State, Zip', 'ucf-bands' ),
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

	/**
	 * Get a single piece of contact information (theme mod)
	 *
	 * @since  3.0.0
	 *
	 * @param  string $field  Theme mod value to get.
	 * @return string         Formatted field.
	 */
	public function get_contact( $field ) {

		// Check cache.
		if ( isset( $this->contacts[ $field ] ) ) {
			return $this->contacts[ $field ];
		}

		$value = apply_filters(
			"ucf_bands_get_contact_$field",
			get_theme_mod( "{$this->prefix}_$field" )
		);

		$this->contacts[ $field ] = $value;
		return $value;
	}

	/**
	 * Get the formatted address
	 *
	 * @since  3.0.0
	 *
	 * @return string
	 */
	public function get_address() {

		// Check cache.
		if ( isset( $this->contacts['address'] ) ) {
			return $this->contacts['address'];
		}

		// Get all the pieces.
		for ( $line = 1; $line <= 4; $line++ ) {
			$lines[ "addr_$line" ] = $this->get_contact( "addr_$line" );
		}

		// Filter out the empty ones and separate with <br>.
		$lines = implode( '<br>', array_filter( $lines ) );

		return "<address>$lines</address>";
	}

	/**
	 * Output formatted address
	 *
	 * @since 3.0.0
	 */
	public function do_address() {
		echo $this->get_address(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
