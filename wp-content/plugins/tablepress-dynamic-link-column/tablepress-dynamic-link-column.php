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
		$this->set_constants();
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Hook in our functionality
	 *
	 * @since 0.1.0
	 */
	public function init() {
		do_action( 'tablepress_dynamic_link_column_loaded' );
	}

	/**
	 * Set constants
	 *
	 * @since 0.1.0
	 */
	private function set_constants() {
		define( 'TABLEPRESS_DYNAMIC_LINK_COLUMN_VERSION', '0.1.0' );
		define( 'TABLEPRESS_DYNAMIC_LINK_COLUMN_DIR', plugin_dir_path( __FILE__ ) );
		define( 'TABLEPRESS_DYNAMIC_LINK_COLUMN_URL', plugin_dir_url( __FILE__ ) );
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
