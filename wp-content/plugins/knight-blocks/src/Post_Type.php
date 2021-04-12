<?php
/**
 * Custom post type handling
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
 * CPT handling abstract
 *
 * @since 1.0.0
 */
abstract class Post_Type {

	/**
	 * Post type key
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	const CPT_KEY = 'kb_post_type';

	/**
	 * Registration args
	 *
	 * @since 1.0.0
	 * @var   array
	 */
	protected $cpt_args = [];

	/**
	 * Object class to be used for indivudal instances of the post type
	 *
	 * Ex: If a "Schedule" post type is being setup with "Schedules" as the main
	 * CPT handler (the class extending this class), the "singular class" would
	 * probably be "Schedule" since each item in a loop would be a schedule.
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	protected $singular_class = 'Post';

	/**
	 * Flag for global post variable in look
	 *
	 * @since 1.0.0
	 * @var   boolean
	 */
	protected $loop_global_name = false;

	/**
	 * Hook everything in
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$key = $this::CPT_KEY;
		add_action( 'init', [ $this, 'do_registration' ] );
		add_action( 'knight_blocks_activate', [ $this, 'do_registration' ] );
		add_action( 'init', [ $this, 'do_meta_registration' ] );
		add_action( 'pre_get_posts', [ $this, 'maybe_set_query' ] );
		add_filter( 'enter_title_here', [ $this, 'set_title_placeholder' ] );
		add_action( 'the_post', [ $this, 'do_post_setup' ] );
		add_action( 'template_redirect', [ $this, 'do_redirect' ] );
		add_filter( "manage_{$key}_posts_columns", [ $this, 'set_posts_columns' ] );
		add_filter( "manage_edit-{$key}_sortable_columns", [ $this, 'set_sortable_columns' ], 15 );
		add_action( "manage_{$key}_posts_custom_column", [ $this, 'do_custom_column' ], 20, 2 );
	}

	/**
	 * Get main post type label
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_label() {
		return __( 'Set CPT Label', 'knight-blocks' );
	}

	/**
	 * Get plural post type label
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_plural_label() {
		return __( 'Set Plural CPT Label', 'knight-blocks' );
	}

	/**
	 * Do CPT registration
	 *
	 * @since 1.0.0
	 */
	public function do_registration() {
		register_post_type( $this::CPT_KEY, $this->get_args() );
	}

	/**
	 * Register post type's meta
	 *
	 * @since 1.0.0
	 */
	public function do_meta_registration() {
	}

	/**
	 * Get post type args + defaults
	 *
	 * @since 1.0.0
	 * @see   https://generatewp.com/post-type/
	 *
	 * @return array  Custom post type registration args.
	 */
	public function get_args() {

		return array_merge_recursive(
			[
				'label'             => $this->get_label(),
				'labels'            => [
					'name'                  => $this->get_plural_label(),
					'menu_name'             => $this->get_plural_label(),
					'singular_name'         => $this->get_label(),
					'name_admin_bar'        => $this->get_label(),
					'add_new'               => __( 'Add New', 'knight-blocks' ),
					'not_found'             => __( 'Not found', 'knight-blocks' ),
					'not_found_in_trash'    => __( 'Not found in Trash', 'knight-blocks' ),
					'featured_image'        => __( 'Featured Image', 'knight-blocks' ),
					'set_featured_image'    => __( 'Set featured image', 'knight-blocks' ),
					'remove_featured_image' => __( 'Remove featured image', 'knight-blocks' ),
					'use_featured_image'    => __( 'Use as featured image', 'knight-blocks' ),
				],
				'hierarchical'      => false,
				'show_in_menu'      => true,
				'menu_position'     => 5,
				'show_in_admin_bar' => true,
				'can_export'        => true,
				'capability_type'   => 'page',
				'show_in_rest'      => true,
			],
			$this->get_cpt_args()
		);
	}

	/**
	 * Get non-default post type args
	 *
	 * @since 1.0.0
	 */
	protected function get_cpt_args() {
		return [];
	}

	/**
	 * Do query setter if we're on the main archive query for this post type.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Query $query  Current query.
	 */
	public function maybe_set_query( $query ) {

		if (
			( $query->is_main_query() && $query->is_post_type_archive( static::CPT_KEY ) )
			|| $query->get( 'post_type' ) === static::CPT_KEY
		) {
			$this->set_query( $query );
		}
	}

	/**
	 * Make adjustments to WP_Query
	 *
	 * It should already be a main query for the current post type's archive.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Query $query  Main query object.
	 */
	protected function set_query( $query ) {
	}

	/**
	 * Get editor title field placeholder
	 *
	 * @since 1.0.0
	 *
	 * @return boolean|string
	 */
	protected function get_title_placeholder() {
		return false;
	}

	/**
	 * Set admin "title" field placeholder
	 *
	 * @since 1.0.0
	 *
	 * @param  string $title  Existing placeholder.
	 * @return string $title  New placeholder, if applicable.
	 */
	public function set_title_placeholder( $title ) {

		$screen = get_current_screen();

		return $this::CPT_KEY === $screen->post_type && $this->get_title_placeholder()
			? $this->get_title_placeholder()
			: $title;
	}

	/**
	 * Set up the global custom post type post object
	 *
	 * Inspired by WooCommerce's wc_setup_product_data
	 *
	 * @since 1.0.0
	 *
	 * @param  WP_Post $post  Post object that is being set up in loop.
	 * @return Product
	 */
	public function do_post_setup( $post ) {

		if ( ! $this->loop_global_name ) {
			return;
		}

		// Reset prior loop item's global.
		unset( $GLOBALS[ "kb_{$this->loop_global_name}" ] );

		// Make sure it's an actual WP_Post object if it isn't already.
		if ( is_int( $post ) ) {
			$post = get_post();
		}

		// Make sure there's a post type and it's the current CPT handler.
		if ( empty( $post->post_type ) || $this::CPT_KEY !== $post->post_type ) {
			return;
		}

		// Put together the actual class for the object to be created.
		$post_class = 'Knight_Blocks\\' . $this->singular_class;

		// Assign global loop object. Ex: global $kb_schedule will be an
		// instance of Knight_Blocks\Schedule.
		//
		// @todo Remove this PHPCS ignore if the rules can get it's crap
		// together. For some reason, "kb" conflicts with the "too short"
		// rule or something and flags the "no prefix" one. Super annoying.
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
		$GLOBALS[ "kb_{$this->loop_global_name}" ] = new $post_class( $post->ID );

		return $GLOBALS[ "kb_{$this->loop_global_name}" ];
	}

	/**
	 * Get location of singular redirect, if applicable
	 *
	 * @since 1.0.0
	 *
	 * @return mixed
	 *  - false: don't do anything (go to single)
	 *  - true: go to site URL
	 *  - string: go to other
	 */
	public function get_singular_redirect() {
		return false;
	}

	/**
	 * Get location of archive redirect, if applicable
	 *
	 * @since 1.0.0
	 *
	 * @return mixed
	 *  - false: don't do anything (go to archive)
	 *  - true: go to site URL
	 *  - string: go to other
	 */
	public function get_archive_redirect() {
		return false;
	}

	/**
	 * Redirect singular or archive view?
	 *
	 * @since 1.0.0
	 */
	public function do_redirect() {

		$url = false;

		if ( is_singular( $this::CPT_KEY ) ) {
			$url = $this->get_singular_redirect();
		} elseif ( is_post_type_archive( $this::CPT_KEY ) ) {
			$url = $this->get_archive_redirect();
		}

		if ( $url ) {
			// Allow redirects out of site.
			// phpcs:ignore WordPress.Security.SafeRedirect
			wp_redirect( true === $url ? site_url() : $url );
			exit;
		}
	}

	/**
	 * Manage admin columns
	 *
	 * @since 1.0.0
	 *
	 * @param  array $columns  Column headings.
	 * @return array $columns
	 */
	public function set_posts_columns( $columns ) {
		return $columns;
	}

	/**
	 * Manage sortable admin columns
	 *
	 * @since 1.0.0
	 *
	 * @param  array $columns  Sortable columns.
	 * @return array $columns
	 */
	public function set_sortable_columns( $columns ) {
		return $columns;
	}

	/**
	 * Output custom admin column contents
	 *
	 * @since 1.0.0
	 *
	 * @param string $name  Column name.
	 */
	public function do_custom_column( $name ) {
		return null;
	}

	/**
	 * Get post type's archive URL
	 *
	 * @since 1.0.0
	 *
	 * @return string  Post type archive link/URL.
	 */
	public static function get_archive_url() {
		return get_post_type_archive_link( static::CPT_KEY );
	}
}
