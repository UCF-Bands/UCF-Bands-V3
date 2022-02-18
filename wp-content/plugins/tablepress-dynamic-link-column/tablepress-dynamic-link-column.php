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

		do_action( 'tablepress_dynamic_link_column_loaded' );
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
