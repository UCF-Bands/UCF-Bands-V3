/**
 * Add postcss plugins to @wordpress/scripts'
 *
 * @package Knight_Blocks
 */

// this had postcss-custom-properties and autoprefixer but the grid: true
// autoprefixer option was breaking some grid-template-* properties in the build
// const defaultPlugins = require( "@wordpress/postcss-plugins-preset" );

module.exports = () => ( {
	plugins: [
		// ...defaultPlugins,
		require( 'postcss-custom-properties' )(),
		require( 'autoprefixer' )(/*{ grid: true }*/),

		require( 'postcss-discard-comments' )(),
		// require( 'postcss-mixins' )(), // @todo CSS this won't work until @wordpress/scripts' post-css loader is updated @see https://github.com/WordPress/gutenberg/issues/27028
		require( 'postcss-nesting' )(),
		require( 'postcss-custom-media' )( {
			preserve: false,
			importFrom: [ './src/editor/_custom-media.css' ],
		} ),
	],
} );
