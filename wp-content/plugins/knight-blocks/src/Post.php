<?php
/**
 * Abstraction of a post
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

namespace Knight_Blocks;

// exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Base class for setting post's basic things and getting cached meta
 *
 * @since 1.0.0
 */
class Post {

	/**
	 * Associated post ID
	 *
	 * @since 1.0.0
	 * @var   integer
	 */
	private $id;

	/**
	 * Meta cache
	 *
	 * @since 1.0.0
	 * @var   array
	 */
	private $meta = [];

	/**
	 * Hook everything in
	 *
	 * @since 1.0.0
	 *
	 * @param integer $post_id  Associated post ID.
	 */
	public function __construct( $post_id = null ) {
		$this->id = $post_id ?? get_the_ID();
	}

	/**
	 * Get post ID
	 *
	 * @since 1.0.0
	 *
	 * @return integer
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Check and retrive something from the post's meta
	 *
	 * @since 1.0.0
	 *
	 * @param  string $key  Meta key/field.
	 * @return mixed
	 */
	protected function get( $key ) {

		if ( isset( $this->meta[ $key ] ) ) {
			return $this->meta[ $key ];
		}

		$this->meta[ $key ] = \get_post_meta( $this->get_id(), $key, true );
		return $this->meta[ $key ];
	}

	/**
	 * Get post title
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_title() {
		return \get_the_title( $this->get_id() );
	}

	/**
	 * Output post title
	 *
	 * @since 1.0.0
	 */
	public function do_title() {
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $this->get_title();
	}
}
