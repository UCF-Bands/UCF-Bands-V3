<?php
/**
 * Plugin Name:     TablePress: Add to Gravity Forms list
 * Plugin URI:      https://jordanpak.com
 * Description:     Inserts selected TablePress rows into a Gravity Form "list" field.
 * Author:          JordanPak
 * Author URI:      https://jordanpak.com
 * Text Domain:     tablepress-add-to-gform-list
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         TablePress_Add_To_GForm_List
 */

namespace TablePress_Add_To_GForm_List;

// Set constants.
define( 'TABLEPRESS_ADD_TO_GFORM_LIST_VERSION', '0.1.0' );
define( 'TABLEPRESS_ADD_TO_GFORM_LIST_DIR', plugin_dir_path( __FILE__ ) );
define( 'TABLEPRESS_ADD_TO_GFORM_LIST_URL', plugin_dir_url( __FILE__ ) );
define( 'TABLEPRESS_ADD_TO_GFORM_LIST_BUILD_DIR', TABLEPRESS_ADD_TO_GFORM_LIST_DIR . 'build' );
define( 'TABLEPRESS_ADD_TO_GFORM_LIST_BUILD_URL', TABLEPRESS_ADD_TO_GFORM_LIST_URL . 'build' );

/**
 * Plugin wrapper
 *
 * @since 0.1.0
 */
class Plugin {

	/**
	 * The single instance of this class
	 *
	 * @since 0.1.0
	 * @var   Plugin
	 */
	protected static $instance;

	/**
	 * Get main plugin instance.
	 *
	 * @since 0.1.0
	 * @see   instance()
	 *
	 * @return Plugin
	 */
	public static function instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Spin up plugin
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Hook in our functionality
	 *
	 * @since 0.1.0
	 */
	public function init() {
		add_filter( 'tablepress_shortcode_table_default_shortcode_atts', [ $this, 'add_shortcode_atts' ] );
		add_filter( 'tablepress_table_raw_render_data', [ $this, 'add_column' ], 10, 2 );
		add_filter( 'tablepress_table_output', [ $this, 'add_checkbox_submit' ], 5, 3 );

		do_action( 'tablepress_add_to_gform_list_loaded' );
	}

	/**
	 * Add shortcode attributes
	 *
	 * @since 0.1.0
	 *
	 * @param  array $atts  Existing [table] shortcode attributes.
	 * @return array $atts
	 */
	public function add_shortcode_atts( $atts ) {
		$atts['add_to_gform_list_template']        = '';
		$atts['add_to_gform_list_heading']         = '';
		$atts['add_to_gform_list_submit_text']     = '';
		$atts['add_to_gform_list_form_url']        = '';
		$atts['add_to_gform_list_form_field_name'] = false;
		return $atts;
	}

	/**
	 * Insert checkbox column into table
	 *
	 * @since 0.1.0
	 *
	 * @param  array $table           Table data and details.
	 * @param  array $render_options  Table render options.
	 * @return array $table
	 */
	public function add_column( $table, $render_options ) {

		// Bounce if there's no "value" to pass from the selected item.
		if ( empty( $table['data'] ) || empty( $render_options['add_to_gform_list_template'] ) ) {
			return $table;
		}

		$header = [];

		foreach ( $table['data'] as $index => &$row ) {

			// Don't apply to column header or footer.
			if (
				( 0 === $index && true === $render_options['table_head'] )
				|| ( count( $table['data'] ) - 1 === $index && true === $render_options['table_foot'] )
			) {
				$header = array_flip( $row );
				array_push(
					$row,
					esc_html( $render_options['add_to_gform_list_heading'] ?: __( 'Add', 'tablepress-add-to-gform-list' ) )
				);
				continue;
			}

			array_push(
				$row,
				'<div class="tp-add-to-gform-list-select">'
					. '<input type="checkbox" name="tp-add-to-gform-list[' . esc_attr( $index ) . ']" id="tp-add-to-gform-list-' . esc_attr( $index ) . '" class="tp-add-to-gform-list-checkbox" value="' . esc_attr( $this->get_parsed_template( $render_options['add_to_gform_list_template'], $header, $row ) ) . '">'
					. '<label for="tp-add-to-gform-list-' . esc_attr( $index ) . '"><span class="screen-reader-text">' . esc_html__( 'Add', 'tablepress-add-to-gform-list' ) . '</span></label>'
				. '</div>'
			);
		}

		return $table;
	}

	/**
	 * Add checkbox submit
	 *
	 * @param string $output         The generated HTML for the table.
	 * @param array  $table          The current table.
	 * @param array  $render_options The render options for the table.
	 */
	public function add_checkbox_submit( $output, $table, $render_options ) {

		// Do the same sanity check as the column thing.
		if ( empty( $table['data'] ) || empty( $render_options['add_to_gform_list_template'] ) ) {
			return $output;
		}

		$this->enqueue_public_scripts();

		$output .=
			'<button class="tp-add-to-gform-list-submit"'
				. 'data-tp-add-to-gform-list-for="#tablepress-' . esc_attr( $table['id'] ) . '"'
				. 'data-tp-add-to-gform-list-url="' . esc_attr( $render_options['add_to_gform_list_form_url'] ) . '"'
				. 'data-tp-add-to-gform-list-field-name="' . esc_attr( $render_options['add_to_gform_list_form_field_name'] ) . '"'
			. '>'
				. esc_html( $render_options['add_to_gform_list_submit_text'] ?: __( 'Submit', 'tablepress-add-to-gform-list' ) )
			. '</button>';

		return $output;
	}

	/**
	 * Evaluate column "value template"
	 *
	 * Mustache-style tags are replaced with the value of the label's column.
	 * So, the value of the "Taco Bell" column in the row would be retreived
	 * with "{{Taco Bell}}" in the template.
	 *
	 * @since 0.1.0
	 *
	 * @param  string $template  Value template with mustache tags for column headings.
	 * @param  array  $header    Table header label => column index mapping.
	 * @param  array  $row       Column values.
	 * @return string            Evaluated template.
	 */
	private function get_parsed_template( $template, $header, $row ) {

		foreach ( $header as $label => $index ) {
			$template = str_replace( '{{' . $label . '}}', $row[ $index ], $template );
		}

		return $template;
	}

	/**
	 * Enqueue public/front-end JS
	 *
	 * @since 0.1.0
	 */
	public function enqueue_public_scripts() {
		$asset = require TABLEPRESS_ADD_TO_GFORM_LIST_BUILD_DIR . '/public.asset.php';

		wp_enqueue_script(
			'tp-add-to-gform-list-public',
			TABLEPRESS_ADD_TO_GFORM_LIST_BUILD_URL . '/public.js',
			array_merge( $asset['dependencies'], [ 'jquery' ] ),
			$asset['version'],
			true
		);
	}
}

/**
 * Get instance of main plugin class
 *
 * @since 0.1.0
 *
 * @return Plugin
 */
function instance() {
	return Plugin::instance();
}

// Instantiate plugin wrapper class.
$tablepress_add_to_gform_list = instance();
