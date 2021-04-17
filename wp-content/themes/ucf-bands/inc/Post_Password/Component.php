<?php
/**
 * WP_Rig\WP_Rig\Post_Password\Component class
 *
 * @todo    Blog on this?
 * @since   3.0.0
 * @package ucf_bands
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
		add_action( 'save_post', [ $this, 'set_pre_read_more_blocks' ], 15, 2 );
		add_filter( 'the_password_form', [ $this, 'add_pre_password_form_blocks' ] );
		add_filter( 'gettext', [ $this, 'set_text' ], 10, 3 );
	}

	/**
	 * Save blocks before password-protected "Read More" block
	 *
	 * @since 3.0.0
	 *
	 * @param integer $post_id  Saved post ID.
	 * @param WP_Post $post     Saved post object.
	 */
	public function set_pre_read_more_blocks( $post_id, $post ) {

		// Make sure we're password protected and there's a "more" block.
		if ( ! post_password_required( $post ) || ! has_block( 'core/more', $post ) ) {
			update_post_meta( $post_id, 'pre_read_more_blocks', [] );
			return;
		}

		$pre_read_more_blocks = [];

		// Grab blocks and make sure they're real blocks.
		$blocks = wp_list_filter( parse_blocks( $post->post_content ), [ 'blockName' => null ], 'NOT' );

		// Get the index of the "more" block.
		$more_blocks = wp_list_filter( $blocks, [ 'blockName' => 'core/more' ] );
		$more_index  = array_keys( $more_blocks )[0];

		// Add each block before "more" block to list.
		foreach ( $blocks as $index => $block ) {
			if ( $index < $more_index ) {
				$pre_read_more_blocks[] = $block;
			}
		}

		update_post_meta( $post_id, 'pre_read_more_blocks', $pre_read_more_blocks );
	}

	/**
	 * Render "pre-read-more" blocks before password form.
	 *
	 * @since 3.0.0
	 *
	 * @param  string $output  The password form HTML output.
	 * @return string
	 */
	public function add_pre_password_form_blocks( $output ) {

		$pre_read_more_blocks = get_post_meta( get_the_ID(), 'pre_read_more_blocks', true );

		if ( ! $pre_read_more_blocks ) {
			return $output;
		}

		foreach ( $pre_read_more_blocks as $block ) {
			$rendered[] = render_block( $block );
		}

		return implode( '', $rendered ) . $output;
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
				return '<span class="h4"><i class="far fa-shield-alt"></i> ' . __( 'State the password', 'ucf-bands' ) . '</span>';

			default:
				return $translation;
		}
	}
}
