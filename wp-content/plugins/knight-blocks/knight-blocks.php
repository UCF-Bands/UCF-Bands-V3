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

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Constants
 */
define( 'KNIGHT_BLOCKS_VERSION', '1.0.0' );

/**
 * Block Initializer.
 */
function knight_blocks_loader() {

	$src_dir = plugin_dir_path( __FILE__ ) . 'src/';

	require_once $src_dir . 'init.php';
}
add_action( 'plugins_loaded', 'knight_blocks_loader' );
