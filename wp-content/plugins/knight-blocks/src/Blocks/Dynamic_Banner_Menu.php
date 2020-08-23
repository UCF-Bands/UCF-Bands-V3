<?php
/**
 * Dynamic banner menu dynamic block
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

namespace Knight_Blocks\Blocks;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dynamic banner menu block handler
 *
 * @since 1.0.0
 */
class Dynamic_Banner_Menu {

	/**
	 * Set up hooks
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'init', [ __CLASS__, 'do_registration' ] );
	}

	/**
	 * Register block
	 *
	 * @since 1.0.0
	 */
	public static function do_registration() {

		register_block_type(
			'knight-blocks/dynamic-banner-menu',
			[
				'render_callback' => [ __CLASS__, 'render' ],
			]
		);
	}

	/**
	 * Render block
	 *
	 * @return string  Block HTML.
	 * @since  1.0.0
	 */
	public static function render() {

		\ob_start();

		?>

		<p><?php esc_html_e( 'Ok this is dynamic bro', 'knight-blocks' ); ?></p>

		<?php
		return \ob_get_clean();
	}
}
