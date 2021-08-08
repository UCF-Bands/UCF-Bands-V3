<?php
/**
 * WP_Rig\WP_Rig\Post_Password\Component class
 *
 * @todo    Blog on this?
 * @since   3.0.0
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Post_Password;

use WP_Rig\WP_Rig\Component_Interface;
use function add_filter;

/**
 * Class for post password protection and UI handling
 *
 * @since 3.0.0
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @since 3.0.0
	 *
	 * @return string  Component slug.
	 */
	public function get_slug() : string {
		return 'post_password';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 *
	 * @since 3.0.0
	 */
	public function initialize() {
		add_filter( 'gettext', [ $this, 'set_text' ], 10, 3 );
	}

	/**
	 * Do misc password form text translations/replacements
	 *
	 * @since 3.0.0
	 *
	 * @param  string $translation  Translated text.
	 * @param  string $text         Text to translate.
	 * @param  string $domain       Text domain. Unique identifier for retrieving translated strings.
	 * @return string
	 */
	public function set_text( $translation, $text, $domain ) {

		// Only run on WordPress core stuff.
		if ( 'default' !== $domain ) {
			return $translation;
		}

		switch ( $text ) {
			case 'This content is password protected. To view it please enter your password below:':
				return '<span class="h4"><i class="far fa-shield-alt"></i> ' . __( 'State the password', 'wp-rig' ) . '</span>';

			default:
				return $translation;
		}
	}
}
