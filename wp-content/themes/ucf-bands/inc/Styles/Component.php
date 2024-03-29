<?php
/**
 * WP_Rig\WP_Rig\Styles\Component class
 *
 * @since   3.0.0
 * @package ucf_bands
 */

namespace WP_Rig\WP_Rig\Styles;

use WP_Rig\WP_Rig\Component_Interface;
use WP_Rig\WP_Rig\Templating_Component_Interface;
use function WP_Rig\WP_Rig\ucf_bands;
use function add_action;
use function add_filter;
use function wp_enqueue_style;
use function wp_register_style;
use function wp_style_add_data;
use function get_theme_file_uri;
use function get_theme_file_path;
use function wp_styles;
use function esc_attr;
use function esc_url;
use function wp_style_is;
use function _doing_it_wrong;
use function wp_print_styles;
use function post_password_required;
use function is_singular;
use function comments_open;
use function get_comments_number;
use function apply_filters;
use function add_query_arg;

/**
 * Class for managing stylesheets.
 *
 * Exposes template tags:
 * * `ucf_bands()->print_styles()`
 *
 * @since 3.0.0
 */
class Component implements Component_Interface, Templating_Component_Interface {

	/**
	 * Associative array of CSS files, as $handle => $data pairs.
	 * $data must be an array with keys 'file' (file path relative to 'assets/css' directory), and optionally 'global'
	 * (whether the file should immediately be enqueued instead of just being registered) and 'preload_callback'
	 * (callback function determining whether the file should be preloaded for the current request).
	 *
	 * Do not access this property directly, instead use the `get_css_files()` method.
	 *
	 * @since 3.0.0
	 * @var   array
	 */
	protected $css_files;

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @since 3.0.0
	 *
	 * @return string  Component slug.
	 */
	public function get_slug() : string {
		return 'styles';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 *
	 * @since 3.0.0
	 */
	public function initialize() {
		add_action( 'admin_enqueue_scripts', [ $this, 'action_admin_enqueue_styles' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'action_enqueue_font_loader' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'action_enqueue_font_awesome' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'action_enqueue_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'action_enqueue_font_loader' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'action_enqueue_font_awesome' ] );
		add_action( 'wp_head', [ $this, 'action_preload_styles' ] );
		add_action( 'after_setup_theme', [ $this, 'action_add_editor_styles' ] );
	}

	/**
	 * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `ucf_bands()`.
	 *
	 * @since 3.0.0
	 *
	 * @return array  Associative array of $method_name => $callback_info pairs. Each $callback_info must either be
	 *                a callable or an array with key 'callable'. This approach is used to reserve the possibility of
	 *                adding support for further arguments in the future.
	 */
	public function template_tags() : array {
		return [
			'print_styles' => [ $this, 'print_styles' ],
		];
	}

	/**
	 * Enqueue admin-specific styles
	 *
	 * @since 3.0.0
	 */
	public function action_admin_enqueue_styles() {

		$css_uri = get_theme_file_uri( '/assets/css/editor' );
		$css_dir = get_theme_file_path( '/assets/css/editor' );

		wp_enqueue_style(
			'ucf-bands-editor-global',
			"$css_uri/global.min.css",
			[],
			ucf_bands()->get_asset_version( "$css_dir/global.min.css" )
		);
	}

	/**
	 * Registers or enqueues stylesheets.
	 *
	 * Stylesheets that are global are enqueued. All other stylesheets are only registered, to be enqueued later.
	 *
	 * @since 3.0.0
	 */
	public function action_enqueue_styles() {

		$css_uri = get_theme_file_uri( '/assets/css/' );
		$css_dir = get_theme_file_path( '/assets/css/' );

		$preloading_styles_enabled = $this->preloading_styles_enabled();

		$css_files = $this->get_css_files();
		foreach ( $css_files as $handle => $data ) {
			$src     = $css_uri . $data['file'];
			$version = ucf_bands()->get_asset_version( $css_dir . $data['file'] );

			/*
			 * Enqueue global stylesheets immediately and register the other ones for later use
			 * (unless preloading stylesheets is disabled, in which case stylesheets should be immediately
			 * enqueued based on whether they are necessary for the page content).
			 */
			if ( $data['global'] || ! $preloading_styles_enabled && is_callable( $data['preload_callback'] ) && call_user_func( $data['preload_callback'] ) ) {
				wp_enqueue_style( $handle, $src, [], $version, $data['media'] );
			} else {
				wp_register_style( $handle, $src, [], $version, $data['media'] );
			}

			wp_style_add_data( $handle, 'precache', true );
		}
	}

	/**
	 * Get Web Font loader and load the TypeKit fonts.
	 *
	 * @since 3.0.0
	 * @see   https://github.com/typekit/webfontloader#typekit
	 */
	public function action_enqueue_font_loader() {

		// Load the Web Font Loader.
		wp_enqueue_script( 'ucf-bands-web-font-loader', 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js', [], '1.6.26', true );

		// Add the Google fonts.
		$fonts = [
			'Open Sans:400,400i,700,700i',
			'Montserrat:500,700,800',
			'Droid Serif:400i,700i',
		];
		$fonts = '\'' . implode( '\', \'', $fonts ) . '\'';

		wp_add_inline_script(
			'ucf-bands-web-font-loader',
			"WebFont.load({ google: { families: [$fonts] } });"
		);
	}

	/**
	 * Enqueue Font Awesome Kit JS
	 *
	 * @since 3.0.0
	 */
	public function action_enqueue_font_awesome() {
		wp_enqueue_script( 'font-awesome', 'https://kit.fontawesome.com/bfd47f16db.js', [], '5', true );
	}

	/**
	 * Preloads in-body stylesheets depending on what templates are being used.
	 *
	 * Only stylesheets that have a 'preload_callback' provided will be considered. If that callback evaluates to true
	 * for the current request, the stylesheet will be preloaded.
	 *
	 * Preloading is disabled when AMP is active, as AMP injects the stylesheets inline.
	 *
	 * @since 3.0.0
	 * @link  https://developer.mozilla.org/en-US/docs/Web/HTML/Preloading_content
	 */
	public function action_preload_styles() {

		// If preloading styles is disabled, return early.
		if ( ! $this->preloading_styles_enabled() ) {
			return;
		}

		$wp_styles = wp_styles();

		$css_files = $this->get_css_files();
		foreach ( $css_files as $handle => $data ) {

			// Skip if stylesheet not registered.
			if ( ! isset( $wp_styles->registered[ $handle ] ) ) {
				continue;
			}

			// Skip if no preload callback provided.
			if ( ! is_callable( $data['preload_callback'] ) ) {
				continue;
			}

			// Skip if preloading is not necessary for this request.
			if ( ! call_user_func( $data['preload_callback'] ) ) {
				continue;
			}

			$preload_uri = $wp_styles->registered[ $handle ]->src . '?ver=' . $wp_styles->registered[ $handle ]->ver;

			echo '<link rel="preload" id="' . esc_attr( $handle ) . '-preload" href="' . esc_url( $preload_uri ) . '" as="style">';
			echo "\n";
		}
	}

	/**
	 * Enqueues WordPress theme styles for the editor.
	 *
	 * @since 3.0.0
	 */
	public function action_add_editor_styles() {

		// Enqueue block editor stylesheet.
		add_editor_style( 'assets/css/editor/editor-styles.min.css' );
	}

	/**
	 * Prints stylesheet link tags directly.
	 *
	 * This should be used for stylesheets that aren't global and thus should only be loaded if the HTML markup
	 * they are responsible for is actually present. Template parts should use this method when the related markup
	 * requires a specific stylesheet to be loaded. If preloading stylesheets is disabled, this method will not do
	 * anything.
	 *
	 * If the `<link>` tag for a given stylesheet has already been printed, it will be skipped.
	 *
	 * @since 3.0.0
	 *
	 * @param string ...$handles  One or more stylesheet handles.
	 */
	public function print_styles( string ...$handles ) {

		// If preloading styles is disabled (and thus they have already been enqueued), return early.
		if ( ! $this->preloading_styles_enabled() ) {
			return;
		}

		$css_files = $this->get_css_files();
		$handles   = array_filter(
			$handles,
			function( $handle ) use ( $css_files ) {
				$is_valid = isset( $css_files[ $handle ] ) && ! $css_files[ $handle ]['global'];
				if ( ! $is_valid ) {
					/* translators: %s: stylesheet handle */
					_doing_it_wrong( __CLASS__ . '::print_styles()', esc_html( sprintf( __( 'Invalid theme stylesheet handle: %s', 'ucf-bands' ), $handle ) ), 'UCF Bands 2.0.0' );
				}
				return $is_valid;
			}
		);

		if ( empty( $handles ) ) {
			return;
		}

		wp_print_styles( $handles );
	}

	/**
	 * Determines whether to preload stylesheets and inject their link tags directly within the page content.
	 *
	 * Using this technique generally improves performance, however may not be preferred under certain circumstances.
	 * For example, since AMP will include all style rules directly in the head, it must not be used in that context.
	 * By default, this method returns true unless the page is being served in AMP. The
	 * {@see 'ucf_bands_preloading_styles_enabled'} filter can be used to tweak the return value.
	 *
	 * @since 3.0.0
	 *
	 * @return bool True  if preloading stylesheets and injecting them is enabled, false otherwise.
	 */
	protected function preloading_styles_enabled() {
		$preloading_styles_enabled = ! ucf_bands()->is_amp();

		/**
		 * Filters whether to preload stylesheets and inject their link tags within the page content.
		 *
		 * @param bool $preloading_styles_enabled Whether preloading stylesheets and injecting them is enabled.
		 */
		return apply_filters( 'ucf_bands_preloading_styles_enabled', $preloading_styles_enabled );
	}

	/**
	 * Gets all CSS files.
	 *
	 * @since 3.0.0
	 *
	 * @return array  Associative array of $handle => $data pairs.
	 */
	protected function get_css_files() : array {
		if ( is_array( $this->css_files ) ) {
			return $this->css_files;
		}

		$css_files = [
			'ucf-bands-global'     => [
				'file'   => 'global.min.css',
				'global' => true,
			],
			'ucf-bands-comments'   => [
				'file'             => 'comments.min.css',
				'preload_callback' => function() {
					return ! post_password_required() && is_singular() && ( comments_open() || get_comments_number() );
				},
			],
			'ucf-bands-content'    => [
				'file'             => 'content.min.css',
				'preload_callback' => '__return_true',
			],
			'ucf-bands-sidebar'    => [
				'file'             => 'sidebar.min.css',
				'preload_callback' => function() {
					return ucf_bands()->is_primary_sidebar_active();
				},
			],
			'ucf-bands-widgets'    => [
				'file'             => 'widgets.min.css',
				'preload_callback' => function() {
					return ucf_bands()->is_primary_sidebar_active();
				},
			],
			'ucf-bands-single'     => [ // does not include single pages.
				'file'             => 'single.min.css',
				'preload_callback' => '__return_true',
			],
			'ucf-bands-page'       => [
				'file'             => 'page.min.css',
				'preload_callback' => '__return_true',
			],
			'ucf-bands-front-page' => [
				'file' => 'front-page.min.css',
				'preload_callback' => function() {
					global $template;
					return 'front-page.php' === basename( $template );
				},
			],
		];

		/**
		 * Filters default CSS files.
		 *
		 * @param array $css_files Associative array of CSS files, as $handle => $data pairs.
		 *                         $data must be an array with keys 'file' (file path relative to 'assets/css'
		 *                         directory), and optionally 'global' (whether the file should immediately be
		 *                         enqueued instead of just being registered) and 'preload_callback' (callback)
		 *                         function determining whether the file should be preloaded for the current request).
		 */
		$css_files = apply_filters( 'ucf_bands_css_files', $css_files );

		$this->css_files = [];
		foreach ( $css_files as $handle => $data ) {
			if ( is_string( $data ) ) {
				$data = [ 'file' => $data ];
			}

			if ( empty( $data['file'] ) ) {
				continue;
			}

			$this->css_files[ $handle ] = array_merge(
				[
					'global'           => false,
					'preload_callback' => null,
					'media'            => 'all',
				],
				$data
			);
		}

		return $this->css_files;
	}
}
