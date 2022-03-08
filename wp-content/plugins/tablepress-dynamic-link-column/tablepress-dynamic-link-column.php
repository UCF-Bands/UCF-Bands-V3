<?php
/**
 * Plugin Name:     Dynamic Link Column for TablePress
 * Plugin URI:      https://jordanpak.com
 * Description:     Add a dynamic link column to a TablePress table.
 * Author:          JordanPak
 * Author URI:      https://jordanpak.com
 * Text Domain:     tablepress-dynamic-link-column
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Tablepress_Dynamic_Link_Column
 */

namespace Tablepress_Dynamic_Link_Column;

// Set constants
define( 'TABLEPRESS_DYNAMIC_LINK_COLUMN_VERSION', '0.1.0' );
define( 'TABLEPRESS_DYNAMIC_LINK_COLUMN_DIR', plugin_dir_path( __FILE__ ) );
define( 'TABLEPRESS_DYNAMIC_LINK_COLUMN_URL', plugin_dir_url( __FILE__ ) );
define( 'TABLEPRESS_DYNAMIC_LINK_COLUMN_BUILD_DIR', TABLEPRESS_DYNAMIC_LINK_COLUMN_DIR . 'build' );
define( 'TABLEPRESS_DYNAMIC_LINK_COLUMN_BUILD_URL', TABLEPRESS_DYNAMIC_LINK_COLUMN_URL . 'build' );

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
		add_filter( 'tablepress_shortcode_table_default_shortcode_atts', [ $this, 'add_shortcode_checkbox_atts' ] );
		add_filter( 'tablepress_table_raw_render_data', [ $this, 'add_column' ], 10, 2 );
		add_filter( 'tablepress_table_raw_render_data', [ $this, 'add_checkbox_column' ], 10, 2 );
		add_filter( 'tablepress_table_output', [ $this, 'add_checkbox_submit' ], 5, 3 );

		do_action( 'tablepress_dynamic_link_column_loaded' );
	}

	/**
	 * BLESSED: Add "checkbox column" attribute
	 *
	 * @since 0.1.0
	 *
	 * @param  array $atts  Existing [table] shortcode attributes.
	 * @return array $atts
	 */
	public function add_shortcode_checkbox_atts( $atts ) {
		$atts['add_to_gform_list_template']        = '';
		$atts['add_to_gform_list_heading']         = '';
		$atts['add_to_gform_list_submit_text']     = '';
		$atts['add_to_gform_list_form_url']        = '';
		$atts['add_to_gform_list_form_field_name'] = false;
		return $atts;
	}

	/**
	 * Insert dynamic link column into table
	 *
	 * @since 0.1.0
	 *
	 * @param  array $table           Table data and details.
	 * @param  array $render_options  Table render options.
	 * @return array $table
	 */
	public function add_checkbox_column( $table, $render_options ) {

		// Bounce if there's no "value" to pass from the selected item.
		if ( empty( $table['data'] ) || empty( $render_options['add_to_gform_list_template' ] ) ) {
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
					esc_html( $render_options['add_to_gform_list_heading'] ?: __( 'Add', 'tablepress-dynamic-link-column' ) )
				);
				continue;
			}

			array_push(
				$row,
				'<div class="tp-add-to-gform-list-select">'
					. '<input type="checkbox" name="tp-add-to-gform-list[' . esc_attr( $index ) . ']" id="tp-add-to-gform-list-' . esc_attr( $index ) . '" class="tp-add-to-gform-list-checkbox" value="' . esc_attr( $this->get_parsed_template( $render_options['add_to_gform_list_template' ], $header, $row ) ) . '">'
					. '<label for="tp-add-to-gform-list-' . esc_attr( $index ) . '"><span class="screen-reader-text">' . esc_html__( 'Add', 'tablepress-dyanmic-link-column' ) . '</span></label>'
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
				. esc_html( $render_options['add_to_gform_list_submit_text'] ?: __( 'Submit', 'tablepress-dynamic-link-column' ) )
			. '</button>';

		return $output;
	}

	/**
	 * Register new attributes for [table /] shortcode
	 *
	 * @since 0.1.0
	 *
	 * @param  array $default_atts  Existing [table] shortcode attributes.
	 * @return array $default_atts
	 */
	public function add_shortcode_atts( $default_atts ) {
		$default_atts['dynamic_link_column_source_column'] = false;
		$default_atts['dynamic_link_column_text']          = '';
		$default_atts['dynamic_link_column_param']         = '';
		$default_atts['dynamic_link_column_url']           = '';
		return $default_atts;
	}

	/**
	 * Insert dynamic link column into table
	 *
	 * @since 0.1.0
	 *
	 * @param  array $table           Table data and details.
	 * @param  array $render_options  Table render options.
	 * @return array $table
	 */
	public function add_column( $table, $render_options ) {

		// Bounce if we don't have a source column to pull a value from.
		if ( empty( $table['data'] ) || false === $render_options['dynamic_link_column_source_column'] ) {
			return $table;
		}

		foreach ( $table['data'] as $index => &$row ) {

			// Don't apply to column header or footer.
			if (
				( 0 === $index && true === $render_options['table_head'] )
				|| ( count( $table['data'] ) - 1 === $index && true === $render_options['table_foot'] )
			) {
				array_push(
					$row,
					esc_html( $render_options['dynamic_link_column_text'] ?: __( 'Link', 'tablepress-dynamic-link-column' ) )
				);
				continue;
			}

			// Take the value of the designated column and insert it as the
			// parameter in a link in a new column at the end.
			array_push(
				$row,
				sprintf(
					'<a class="tablepress-dynamic-link-column-link" href="%1$s">%2$s</a>',
					add_query_arg(
						urlencode( $render_options['dynamic_link_column_param'] ?: 'tp_dynamic_link' ),
						urlencode( $row[ intval( $render_options['dynamic_link_column_source_column'] ) ] ),
						esc_url( $render_options['dynamic_link_column_url'] ?: '#' )
					),
					esc_html( $render_options['dynamic_link_column_text'] ?: __( 'Link', 'tablepress-dynamic-link-column' ) )
				)
			);
		}

		return $table;
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
		$asset = require TABLEPRESS_DYNAMIC_LINK_COLUMN_BUILD_DIR . '/public.asset.php';

		wp_enqueue_script(
			'tp-add-to-gform-list-public',
			TABLEPRESS_DYNAMIC_LINK_COLUMN_BUILD_URL . '/public.js',
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
$tablepress_dynamic_link_column = instance();
