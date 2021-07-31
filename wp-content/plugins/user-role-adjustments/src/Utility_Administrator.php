<?php
/**
 * "Utility Administrator" role setup
 *
 * This is intended to be for accounts that only exist to administer other
 * accounts.
 *
 * @since   1.0.0
 * @package User_Role_Adjustments
 */

namespace User_Role_Adjustments;

// exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main user role registration and capabilities management
 *
 * @since 1.0.0
 */
class Utility_Administrator {

	/**
	 * Role name (key)
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	private static $role = 'utility_administrator';

	/**
	 * Spin everything up
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'user_role_adjustments_activate', [ __CLASS__, 'add_role' ] );
		add_action( 'user_role_adjustments_deactivate', [ __CLASS__, 'remove_role' ] );
		add_filter( 'show_admin_bar', [ __CLASS__, 'set_show_admin_bar' ], 20 );
		add_filter( 'woocommerce_prevent_admin_access', [ __CLASS__, 'set_prevent_admin_access' ], 20 );
	}

	/**
	 * Add the user role
	 *
	 * Additional roles we may want if it's annoying to have to switch the role
	 * back to administrator:
	 * - manage_options
	 * - upload_files
	 * - activate_plugins
	 * - delete_plugins
	 * - install_plugins
	 * - resume_plugins
	 * - update_plugins
	 *
	 * @see   add_role()
	 * @since 1.0.0
	 */
	public static function add_role() {

		add_role(
			self::$role,
			__( 'Utility Administrator', 'user-role-adjustments' ),
			[
				'read'                    => true,
				'edit_dashboard'          => true,
				'export'                  => true,
				'view_site_health_checks' => true,
				'create_users'            => true,
				'delete_users'            => true,
				'edit_users'              => true,
				'list_users'              => true,
				'promote_users'           => true,
				'remove_users'            => true,
			]
		);
	}

	/**
	 * Remove the user role
	 *
	 * @since 1.0.0
	 */
	public static function remove_role() {
		remove_role( self::$role );
	}

	/**
	 * Handle special admin bar conditions
	 *
	 * For example, overrides WooCommerce's edit_posts + manage_woocommerce
	 * admin bar removal condition.
	 *
	 * @param boolean $show_admin_bar Existing admin bar display condition.
	 * @return boolean
	 *
	 * @since 1.0.2
	 */
	public static function set_show_admin_bar( $show_admin_bar ) {

		if ( current_user_can( 'list_users' ) ) {
			return true;
		}

		return $show_admin_bar;
	}

	/**
	 * Set whether or not admin access should be PREVENTED
	 *
	 * This overrides WooCommerce's edit_posts condition.
	 *
	 * @param boolean $prevent_access Existing admin bar display condition.
	 * @return boolean
	 *
	 * @since 1.0.2
	 */
	public static function set_prevent_admin_access( $prevent_access ) {

		if ( current_user_can( 'list_users' ) ) {
			return false;
		}

		return $prevent_access;
	}
}
