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
 * @package Knight_Blocks
 */

namespace Knight_Blocks;

// exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get autoloader and helpers.
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/functions.php';

/**
 * Plugin wrapper
 *
 * @since 1.0.0
 */
class Plugin {

	/**
	 * The single instance of this class
	 *
	 * @since 1.0.0
	 * @var   Plugin
	 */
	protected static $instance;

	/**
	 * Products handler
	 *
	 * @since 1.0.0
	 * @var   Products
	 */
	public $products;

	/**
	 * Blocks handler
	 *
	 * @since 1.0.0
	 * @var   Blocks
	 */
	public $blocks;

	/**
	 * Full Score Events handler
	 *
	 * @since 1.0.0
	 * @var   Full_Score_Events
	 */
	public $full_score_events;

	/**
	 * Get main plugin instance.
	 *
	 * @since 1.0.0
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
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->set_constants();
		add_action( 'plugins_loaded', [ $this, 'init' ] );
		add_action( 'knight_blocks_activate', [ $this, 'init' ] );
		add_action( 'knight_blocks_activate', 'flush_rewrite_rules' );
		add_action( 'knight_blocks_deactivate', 'flush_rewrite_rules' );
		// add_action( 'full_score_events_loaded', [ $this, 'init_full_score_events' ] );.
	}

	/**
	 * Set constants
	 *
	 * @since 1.0.0
	 */
	private function set_constants() {
		define( 'KNIGHT_BLOCKS_VERSION', '1.0.0' );
		define( 'KNIGHT_BLOCKS_DIR', plugin_dir_path( __FILE__ ) );
		define( 'KNIGHT_BLOCKS_URL', plugin_dir_url( __FILE__ ) );
	}

	/**
	 * Get block registration and assets going
	 *
	 * @since 1.0.0
	 */
	public function init() {
		$this->products = new Products();
		$this->blocks   = new Blocks\Blocks();
	}

	/**
	 * Handle activation tasks
	 *
	 * @since 1.0.0
	 */
	public function do_activate() {
		do_action( 'knight_blocks_activate' );
	}

	/**
	 * Handle deactivation tasks
	 *
	 * @since 1.0.0
	 */
	public function do_deactivate() {
		do_action( 'knight_blocks_deactivate' );
	}
}

/**
 * Get instance of main plugin class
 *
 * @since 1.0.0
 *
 * @return Plugin
 */
function instance() {
	return Plugin::instance();
}

// Instantiate plugin wrapper class.
$knight_blocks = instance();

// Register activation/deactivation stuff.
register_activation_hook( __FILE__, [ $knight_blocks, 'do_activate' ] );
register_deactivation_hook( __FILE__, [ $knight_blocks, 'do_deactivate' ] );
