<?php
/**
 * Plugin Name: User Role Adjustments
 * Plugin URI: https://www.designzillas.com
 * Description: Adds "Super Editor" and "Utility Administrator" user roles.
 * Author: Designzillas
 * Author URI: https://www.designzillas.com/
 * Version: 1.0.3
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: user-role-adjustments
 *
 * @package User_Role_Adjustments
 */

namespace User_Role_Adjustments;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get autoloader and helper functions.
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/functions.php';

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
		$this->set_constants();
		add_action( 'plugins_loaded', [ $this, 'init' ] );
		add_action( 'user_role_adjustments_activate', [ $this, 'init' ], 5 );
		add_action( 'user_role_adjustments_activate', 'flush_rewrite_rules' );
		add_action( 'user_role_adjustments_deactivate', 'flush_rewrite_rules' );
	}

	/**
	 * Set constants
	 *
	 * @since 1.0.0
	 */
	private function set_constants() {
		define( 'USER_ROLE_ADJUSTMENTS_VERSION', '1.0.3' );
		define( 'USER_ROLE_ADJUSTMENTS_DIR', plugin_dir_path( __FILE__ ) );
		define( 'USER_ROLE_ADJUSTMENTS_URL', plugin_dir_url( __FILE__ ) );
	}

	/**
	 * Do block and asset registration
	 *
	 * @since 1.0.0
	 */
	public function init() {
		new Super_Editor();
		new Utility_Administrator();
	}

	/**
	 * Handle activation tasks
	 *
	 * @todo  move this to its own class
	 * @since 1.0.0
	 */
	public function do_activate() {
		do_action( 'user_role_adjustments_activate' );
	}

	/**
	 * Handle deactivation tasks
	 *
	 * @todo  move this to its own class
	 * @since 1.0.0
	 */
	public function do_deactivate() {
		do_action( 'user_role_adjustments_deactivate' );
	}
}

// Instantiate plugin wrapper class.
$user_role_adjustments_plugin = new Plugin();

// Register activation/deactivation stuff.
register_activation_hook( __FILE__, [ $user_role_adjustments_plugin, 'do_activate' ] );
register_deactivation_hook( __FILE__, [ $user_role_adjustments_plugin, 'do_deactivate' ] );
