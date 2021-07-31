<?php
/**
 * "Super Editor" role setup
 *
 * This role inherits the "Editor" capabilities and adds on additional
 * capabilities for editing nav menus, using the customizer, and administering
 * Gravity Forms.
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
class Super_Editor {

	/**
	 * Role name (key)
	 *
	 * @var   string
	 * @since 1.0.0
	 */
	private static $role = 'super_editor';

	/**
	 * Spin everything up
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'user_role_adjustments_activate', [ __CLASS__, 'add_role' ] );
		add_action( 'user_role_adjustments_deactivate', [ __CLASS__, 'remove_role' ] );
		add_action( 'admin_head', [ __CLASS__, 'remove_menu_pages' ] );
	}

	/**
	 * Add the user role
	 *
	 * Additional Gravity Forms capabilities that may be of interest:
	 * - gravityforms_edit_settings
	 * - gravityforms_uninstall
	 * - gravityforms_view_addons
	 * - gravityforms_view_settings
	 * - gravityforms_view_updates
	 *
	 * @see   add_role()
	 * @see   https://docs.gravityforms.com/role-management-guide/
	 * @since 1.0.0
	 */
	public static function add_role() {

		$editor_caps = get_role( 'editor' )->capabilities;

		add_role(
			self::$role,
			__( 'Super Editor', 'user-role-adjustments' ),
			array_merge(
				$editor_caps,
				[
					'edit_theme_options'            => true,
					'gravityforms_create_form'      => true,
					'gravityforms_delete_entries'   => true,
					'gravityforms_delete_forms'     => true,
					'gravityforms_edit_entries'     => true,
					'gravityforms_edit_entry_notes' => true,
					'gravityforms_edit_forms'       => true,
					'gravityforms_export_entries'   => true,
					'gravityforms_preview_forms'    => true,
					'gravityforms_system_status'    => true,
					'gravityforms_view_entries'     => true,
					'gravityforms_view_entry_notes' => true,
				]
			)
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
	 * Remove "Appearance" pages that we don't want the role to use
	 *
	 * @since 1.0.0
	 */
	public static function remove_menu_pages() {

		if ( ! current_user_can( self::$role ) ) {
			return;
		}

		// Hide widgets.
		remove_submenu_page( 'themes.php', 'themes.php' );

		// Hide theme selection.
		remove_submenu_page( 'themes.php', 'widgets.php' );
	}
}
