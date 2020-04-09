<?php
/**
 * Plugin Name: Knight Blocks
 * Plugin URI: https://ucfbands.com/
 * Description: A block library for UCF Bands.
 * Author: Jordan Pakrosnis
 * Author URI: https://jordanpak.com/
 * Version: 1.0.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package Knight Blocks
 */

namespace KnightBlocks;

// exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// set constants
define( 'KNIGHT_BLOCKS_VERSION', '1.0.0' );

// get autoloader
require_once 'vendor/autoload.php';

/**
 * Plugin wrapper
 *
 * @since 1.0.0
 */
class Plugin {

	/**
	 * Spin up plugin
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Get block registration and assets going
	 *
	 * @since 1.0.0
	 */
	public function init() {
		new Init();
	}

	/**
	 * Handle activation tasks
	 *
	 * @since 1.0.0
	 */
	public function do_activate() {
		flush_rewrite_rules();
	}

	/**
	 * Handle deactivation tasks
	 *
	 * @since 1.0.0
	 */
	public function do_deactivate() {
		flush_rewrite_rules();
	}
}

// spin up plugin
$kb_plugin = new Plugin();

// register activation/deactivation stuff
register_activation_hook( __FILE__, [ $kb_plugin, 'do_activate' ] );
register_deactivation_hook( __FILE__, [ $kb_plugin, 'do_deactivate' ] );
