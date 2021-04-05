<?php
/**
 * WP_Rig\WP_Rig\Gravity_Forms\Component class
 *
 * @since   3.0.0
 * @package ucf_bands
 */

namespace WP_Rig\WP_Rig\Gravity_Forms;

use WP_Rig\WP_Rig\Component_Interface;
use function add_filter;

/**
 * Class for Gravity Form adjustments/features
 *
 * @since 3.0.0
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'gravity_forms';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_filter( 'gform_init_scripts_footer', '__return_true' );
		add_filter( 'gform_submit_button', [ $this, 'set_submit_button' ], 10, 2 );
		add_filter( 'gform_ajax_spinner_url', [ $this, 'set_spinner_url' ] );
		add_filter( 'gform_field_css_class', [ $this, 'add_field_type_class' ], 10, 2 );
		add_filter( 'gform_field_content', [ $this, 'add_autocomplete_off' ], 10, 2 );
		add_filter( 'gform_confirmation_anchor', '__return_true' );
	}

	/**
	 * Apply the theme's button component to the Gravity Form submit
	 *
	 * This allows us to have a non-"input" DOM element that can be customized
	 * at the full capacity of our button function.
	 *
	 * @param  string $button  Existing Gravity Forms button HTML.
	 * @param  array  $form    Gravity Form information.
	 * @return string          Our own button.
	 *
	 * @since 3.0.0
	 */
	public function set_submit_button( $button, $form ) {

		// Get form ID & text.
		$id        = $form['id'];
		$text      = ! empty( $form['button']['text'] ) ? $form['button']['text'] : __( 'Submit', 'ucf-bands' );
		$tab_index = \GFCommon::$tab_index++;

		return "<button
			type='submit'
			value='submit'
			id='gform_submit_button_{$id}'
			tabindex='$tab_index'
		/>$text</button>";
	}

	/**
	 * Set the AJAX spinner URL
	 *
	 * Get a spinner here (or something): https://loading.io
	 *
	 * @return string New spinner URL
	 * @since  3.0.0
	 */
	public static function set_spinner_url() {
		return get_theme_file_uri( '/assets/images/circle-notch.svg' );
	}

	/**
	 * Add Gravity Form field type to field wrapper class(es)
	 *
	 * @param  string $classes  Existing classes, separated by space.
	 * @param  object $field    Field object.
	 * @return string           New class(es).
	 *
	 * @since 3.0.0
	 */
	public static function add_field_type_class( $classes, $field ) {
		return $classes .= ' gfield_' . $field->get_input_type();
	}

	/**
	 * Turn "autocomplete" off on certain field types
	 *
	 * @param  string $field_content  Field HTML.
	 * @param  object $field          Field object.
	 * @return string                 new HTML
	 *
	 * @since  3.0.0
	 */
	public static function add_autocomplete_off( $field_content, $field ) {

		// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		if ( empty( $field->dateType ) || 'datepicker' !== $field->dateType ) {
			return $field_content;
		}

		return str_replace( 'type=', 'autocomplete="off" type=', $field_content );
	}
}
