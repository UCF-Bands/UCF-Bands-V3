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
		// remove_action( 'customize_register', [ fse()->customizer, 'add_section' ] );.

		foreach ( [
			'full_score_events_before_main_content',
			'full_score_events_before_upcoming_events',
		] as $action ) {
			add_action( $action, [ $this, 'do_styles' ] );
		}

		add_action( 'wp_enqueue_scripts', [ $this, 'action_enqueue_scripts' ] );
		add_action( 'full_score_events_after_customizer_events_controls', [ $this, 'add_customizer_events_controls' ], 10, 2 );
		remove_action( 'full_score_events_loop_after_events', 'the_posts_pagination' );
		add_action( 'full_score_events_loop_after_events', [ $this, 'do_pagination' ] );
		add_filter( 'full_score_events_event_single_thumbnail_size', [ $this, 'set_event_single_thumbnail_size' ] );
	}

	/**
	 * Print global/shared CSS
	 *
	 * @since 1.0.0
	 */
	public function do_styles() {
		wp_rig()->print_styles( 'wp-rig-content', 'wp-rig-fse' );

		if ( is_event_archive() ) {
			wp_rig()->print_styles( 'wp-rig-fse-events' );
		} elseif ( is_event() ) {
			wp_rig()->print_styles( 'wp-rig-fse-event' );
		}
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
}
