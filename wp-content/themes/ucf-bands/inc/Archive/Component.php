<?php
/**
 * WP_Rig\WP_Rig\Archive\Component class
 *
 * @since   3.0.0
 * @package ucf_bands
 */

namespace WP_Rig\WP_Rig\Archive;

use WP_Rig\WP_Rig\Component_Interface;
use function WP_Rig\WP_Rig\ucf_bands;
use WP_Customize_Manager;
use WP_Customize_Media_Control;
use function add_action;

/**
 * Class for shared archive features
 *
 * @since 3.0.0
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @since 3.0.0
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'archive';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 *
	 * @since 3.0.0
	 */
	public function initialize() {
		add_filter( 'gettext', [ $this, 'set_text' ] );
		add_filter( 'gettext_with_context', [ $this, 'set_text_with_context' ], 10, 3 );
		add_action( 'customize_register', [ $this, 'add_customizer_settings' ] );
	}

	/**
	 * Set archive text translations
	 *
	 * @since 3.0.0
	 *
	 * @param  string $translation  Translatable text.
	 * @return string
	 */
	public function set_text( $translation ) {

		switch ( $translation ) {
			case 'Archives: %s':
				$translation = '%s';
				break;
		}

		return $translation;
	}

	/**
	 * Set with-context archive text translations
	 *
	 * @since 3.0.0
	 *
	 * @param  string $translation  Translatable text.
	 * @param  string $text         Translated text.
	 * @param  string $context      Context (_x).
	 * @return string
	 */
	public function set_text_with_context( $translation, $text, $context ) {

		// Remove Archives: prefix.
		return 'post type archive title prefix' === $context
			? ''
			: $translation;
	}

	/**
	 * Add customizer settings for header
	 *
	 * @since 3.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize  Customizer manager instance.
	 */
	public function add_customizer_settings( WP_Customize_Manager $wp_customize ) {

		foreach ( [
			'post'        => __( 'Announcements', 'ucf-bands' ),
			'fse_program' => false,
		] as $post_type => $label ) {

			$post_type_object = get_post_type_object( $post_type );
			$label            = $label ? $label : $post_type_object->labels->name;

			// See if we already have a section for the post type, setting to
			// post type key otherwise.
			$section = $wp_customize->get_section( $post_type );

			if ( ! $section ) {
				$section = $wp_customize->add_section( $post_type, [ 'title' => $label ] );
			}

			$setting = "{$post_type}_archive_header_background_image";
			$wp_customize->add_setting( $setting );
			$wp_customize->add_control(
				new WP_Customize_Media_Control(
					$wp_customize,
					$setting,
					[
						'label'    => __( 'Archive Header Background Image', 'ucf-bands' ),
						'settings' => $setting,
						'section'  => $section->id,
					]
				)
			);

			$setting = "{$post_type}_archive_header_subheading";
			$wp_customize->add_setting( $setting );
			$wp_customize->add_control(
				$setting,
				[
					'label'   => __( 'Archive Header Subheading', 'ucf-bands' ),
					'section' => $section->id,
				]
			);
		}
	}
}
