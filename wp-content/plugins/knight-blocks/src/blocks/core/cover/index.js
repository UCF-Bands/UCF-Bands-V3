/**
 * Add cover features
 *
 * @since   1.0.0
 * @package knight-blocks
 */

// import './style.scss';
// import './editor.scss';

import hasBlockStyle from '../../../util/has-block-style';

const { __ } = wp.i18n;
const { registerBlockStyle } = wp.blocks;
const { addFilter } = wp.hooks;
const { createHigherOrderComponent } = wp.compose;

// Register block styles
registerBlockStyle( 'core/cover', [
	{
		name: 'banner',
		label: __( 'Banner', 'knight-blocks' ),
		isDefault: false,
	},
	{
		name: 'jumbo',
		label: __( 'Jumbo Banner', 'knight-blocks' ),
		isDefault: false,
	},
] );

// sanity checker
const isCover = ( name ) => {
	return name === 'core/cover';
};

/**
 * Manage custom on-edit functionality for cover block
 *
 * We're watching for the block's style to change in case a default gradient
 * overlay needs to be set.
 *
 * @param  {function}  BlockEdit  existing advanced inspector components
 * @return {object}               new advanced inspector controls
 *
 * @since  1.0.0
 */
const addControls = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		if ( ! isCover( props.name ) ) {
			return <BlockEdit { ...props } />;
		}

		const
			{ attributes, setAttributes } = props,
			{ className, overlayColor, gradient, gradientAutoSet } = attributes;

		// set if we're "banner" or "jumbo" block style
		const
			isBanner = hasBlockStyle( className, 'banner' ),
			isJumbo = hasBlockStyle( className, 'jumbo' );

		// if it's banner or jumbo and there isn't already a gradient or solid
		// overlay, automatically switch the gradient to "dark-gray-overlay-to-right"
		if (
			( isBanner || isJumbo ) &&
			( ! gradientAutoSet && ! gradient && ! overlayColor )
		) {
			setAttributes( {
				gradientAutoSet: true,
				gradient: 'dark-gray-overlay-to-right',
			} );

		// if we're at the default style now and we're coming from the
		// dark-gray-overlay-to-right gradient, set the overlay/gradient back to default
		} else if (
			( ! isBanner && ! isJumbo ) &&
			( gradient === 'dark-gray-overlay-to-right' )
		) {
			setAttributes( {
				gradientAutoSet: false,
				gradient: null,
			} );
		}

		return <BlockEdit { ...props } />;
	};
}, 'addControls' );

// insert the inspector controls
addFilter(
	'editor.BlockEdit',
	'knight-blocks/cover/add-controls',
	addControls,
);
