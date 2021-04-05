<?php
/**
 * WP_Rig\WP_Rig\Full_Score_Events\Component class
 *
 * @since   1.0.0
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Full_Score_Events;

use WP_Rig\WP_Rig\Component_Interface;
use function WP_Rig\WP_Rig\wp_rig;
use function add_filter;
use function add_action;
use function remove_action;
use function wp_enqueue_script;
use function get_theme_file_uri;
use function get_theme_file_path;
use function wp_script_add_data;
use function \Full_Score_Events\instance as fse;
use function \Full_Score_Events\is_event_archive;
use function \Full_Score_Events\is_event;

/**
 * Class for Full Score Events adjustments/features
 *
 * @since 1.0.0
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 * @since  1.0.0
	 */
	public function get_slug() : string {
		return 'full_score_events';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 *
	 * @since 1.0.0
	 */
	public function initialize() {
		// Ex: remove method from FSE class.
		// remove_action( 'customize_register', [ fse()->customizer, 'add_section' ] );.

		add_filter( 'wp_rig_css_files', [ $this, 'add_css_files' ] );
		add_action( 'full_score_events_before_block', [ $this, 'do_global_styles' ] );
		add_action( 'full_score_events_before_main_content', [ $this, 'do_global_styles' ] );
		add_action( 'full_score_events_before_main_content', [ $this, 'do_template_styles' ], 12 );
		add_action( 'after_setup_theme', [ $this, 'action_add_editor_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'action_enqueue_scripts' ] );
		add_action( 'full_score_events_after_customizer_events_controls', [ $this, 'add_customizer_events_controls' ], 10, 2 );
		remove_action( 'full_score_events_loop_after_events', 'the_posts_pagination' );
		add_action( 'full_score_events_loop_after_events', [ $this, 'do_pagination' ] );
		add_filter( 'full_score_events_event_single_thumbnail_size', [ $this, 'set_event_single_thumbnail_size' ] );
		add_filter( 'full_score_events_all_events_link_attributes', [ $this, 'remove_button_class' ] );
		add_filter( 'full_score_events_schedule_download_attrs', [ $this, 'remove_button_class' ] );
		add_filter( 'full_score_events_registration_link_attrs', [ $this, 'remove_button_background' ] );
	}

	/**
	 * Register CSS with Styles component
	 *
	 * @param  array $css_files  Associative array of CSS files as $handle => $data.
	 * @return array
	 *
	 * @since  1.0.0
	 */
	public function add_css_files( $css_files ) {

		$css_files['wp-rig-fse'] = [
			'file' => 'full-score-events/global.min.css',
		];

		$css_files['wp-rig-fse-events'] = [
			'file' => 'full-score-events/events.min.css',
		];

		$css_files['wp-rig-fse-event'] = [
			'file' => 'full-score-events/event.min.css',
		];

		return $css_files;
	}

	/**
	 * Print global/shared CSS
	 *
	 * @since 1.0.0
	 */
	public function do_global_styles() {
		wp_rig()->print_styles( 'wp-rig-content', 'wp-rig-fse' );
	}

	/**
	 * Print template-specific CSS
	 *
	 * @since 1.0.0
	 */
	public function do_template_styles() {

		if ( is_event_archive() ) {
			wp_rig()->print_styles( 'wp-rig-fse-events' );
		} elseif ( is_event() ) {
			wp_rig()->print_styles( 'wp-rig-fse-event' );
		}
	}

	/**
	 * Enqueues WordPress theme styles for the editor.
	 */
	public function action_add_editor_styles() {
		add_editor_style( 'assets/css/full-score-events/global.min.css' );
		add_editor_style( 'assets/css/full-score-events/editor-styles.min.css' );
	}

	/**
	 * Enqueue front-end helper JS
	 */
	public function action_enqueue_scripts() {

		// If the AMP plugin is active, return early.
		if ( wp_rig()->is_amp() ) {
			return;
		}

		// Enqueue the navigation script.
		wp_enqueue_script(
			'wp-rig-fse',
			get_theme_file_uri( '/assets/js/full-score-events.min.js' ),
			[],
			wp_rig()->get_asset_version( get_theme_file_path( '/assets/js/full-score-events.min.js' ) ),
			false
		);
		wp_script_add_data( 'wp-rig-fse', 'async', true );
		wp_script_add_data( 'wp-rig-fse', 'precache', true );
	}

	/**
	 * Add additional settings/controls to the "Events" customizer section
	 *
	 * @param WP_Customize_Manager $wp_customize  Customizer manager.
	 * @param string               $section       FSE events section key.
	 *
	 * @since 1.0.0
	 */
	public function add_customizer_events_controls( $wp_customize, $section ) {

		$wp_customize->add_setting( 'event_archive_header_background_image' );
		$wp_customize->add_control(
			new \WP_Customize_Media_Control(
				$wp_customize,
				'event_archive_header_background_image',
				[
					'label'    => __( 'Archive Header Background Image', 'wp-rig' ),
					'settings' => 'event_archive_header_background_image',
					'section'  => $section,
				]
			)
		);
	}

	/**
	 * Call our own pagination template
	 *
	 * @since 1.0.0
	 */
	public function do_pagination() {
		get_template_part( 'template-parts/content/pagination' );
	}

	/**
	 * Override default event single thumbnail image size
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function set_event_single_thumbnail_size() {
		return 'knight-blocks-xlarge';
	}

	/**
	 * Remove button block class from misc. buttons
	 *
	 * @param  array $attrs  Button attributes.
	 * @return array         Modified button attributes.
	 *
	 * @since  1.0.0
	 */
	public function remove_button_class( $attrs ) {
		$attrs['class'] = array_diff( $attrs['class'], [ 'wp-block-button__link' ] );
		return $attrs;
	}

	/**
	 * Conditionally remove button background/wings
	 *
	 * @param  array $attrs  Button attributes.
	 * @return array         Modified button attributes.
	 *
	 * @since  1.0.0
	 */
	public function remove_button_background( $attrs ) {

		if ( 'button' !== $attrs['role'] ) {
			$attrs['class'][] = 'no-background';
			$attrs['class'][] = 'no-wings';
		}

		return $attrs;
	}
}
