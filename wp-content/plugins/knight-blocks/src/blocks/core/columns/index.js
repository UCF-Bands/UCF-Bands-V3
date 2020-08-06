/**
 * Add columns-specific block features
 *
 * Add wrapper + other settings to the core/columns block.
 *
 * @since   1.0.0
 * @package knight-blocks
 */

import classnames from 'classnames/dedupe';
import assign from 'lodash/assign';

const { __ } = wp.i18n;
const { addFilter } = wp.hooks;
const { createHigherOrderComponent } = wp.compose;
const { Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, RadioControl, ToggleControl } = wp.components;

// sanity checker
const isColumns = ( name ) => {
	return name === 'core/columns';
};

/**
 * Add custom attributes to block
 *
 * @param  {object}  settings  current block settings
 * @param  {string}  name      current block name
 * @return {object}            modified block settings
 *
 * @since  1.0.0
 */
const addAttributes = ( settings, name ) => {
	if ( ! isColumns( name ) ) {
		return settings;
	}

	// use Lodash's assign to gracefully handle if attrs are undefined
	settings.attributes = assign( settings.attributes, {

		kbSpacing: {
			type: 'string',
			default: '',
		},

		kbReverse: {
			type: 'boolean',
			default: false,
		},
	} );

	return settings;
};

/**
 * Add fields to inspector controls
 *
 * We basically need to "append" this to the inspector controls, so we create a
 * new React component with <Fragment> wrapper containing the existing
 * <BlockEdit> followed by our new <InspectorControls>.
 *
 * @param  {function}  BlockEdit  existing advanced inspector components
 * @return {object}               new advanced inspector controls
 *
 * @since  1.0.0
 */
const addControls = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		if ( ! isColumns( props.name ) ) {
			return <BlockEdit { ...props } />;
		}

		// get attribute helpers, attributes
		const
			{ attributes, setAttributes } = props,
			{
				align,
				kbSpacing,
				kbReverse,
			} = attributes,
			controls = [];

		// Spacing control
		controls.push( <RadioControl
			label={ __( 'Spacing', 'knight-blocks' ) }
			options={ [
				{ label: __( 'None', 'knight-blocks' ), value: 'none' },
				{ label: __( 'Medium', 'knight-blocks' ), value: 'medium' },
				{ label: __( 'Default', 'knight-blocks' ), value: '' },
			] }
			onChange={ ( value ) => setAttributes( { kbSpacing: value } ) }
			selected={ kbSpacing }
		/> );

		// Reverse mobile order control
		controls.push( <ToggleControl
			label={ __( 'Reverse mobile column order', 'knight-blocks' ) }
			help={ __( 'Stack the right column above the left on smaller screens.', 'knight-blocks' ) }
			checked={ kbReverse }
			onChange={ ( value ) => setAttributes( { kbReverse: value } ) }
		/> );

		// give back original <BlockEdit> with our new wrapper
		// .wp-block is for spacing/margins, data-align for max-width
		return (
			<Fragment>

				<InspectorControls>
					<PanelBody title={ __( 'Spacing & Order', 'knight-blocks' ) }>{ controls }</PanelBody>
				</InspectorControls>

				<div
					className={ classnames( {
						'wp-block': true,
						'kb-columns-wrap': true,
						[ `kb-columns-spacing-${ kbSpacing }` ]: kbSpacing,
						'kb-columns-reverse': kbReverse,
					} ) }
					data-align={ align }
				>
					<BlockEdit { ...props } />
				</div>

			</Fragment>
		);
	};
}, 'addControls' );

/**
 * Add custom elements to existing block
 *
 * The outermost element being returned is basically us re-wrapping the outer
 * "cover" container, then put the children (nested blocks) and our custom stuff
 * inside.
 *
 * @param  {object}  element     block element (react.element)
 * @param  {object}  blockType   block type information
 * @param  {object}  attributes  block attributes
 * @return {object}  element
 */
const addElements = ( element, blockType, attributes ) => {
	if ( ! element || ! isColumns( blockType.name ) ) {
		return element;
	}

	const { children, className, style } = element.props;
	const { align, kbSpacing, kbReverse } = attributes;

	return (
		// our new wrapper with alignment class
		<div className={ classnames( {
			'kb-columns-wrap': true,
			[ `kb-columns-spacing-${ kbSpacing }` ]: kbSpacing,
			[ `align${ align }` ]: align,
			'fa-mobile-reverse-order': kbReverse,
		} ) }>

			{ /* re-create the native wrapper, but without alignment */ }
			<div
				className={ classnames( className, {
					[ `align${ align }` ]: false,
				} ) }
				style={ style }
			>
				{ children }
			</div>
		</div>
	);
};

// add the attributes
addFilter(
	'blocks.registerBlockType',
	'knight-blocks/columns/add-attributes',
	addAttributes,
);

// insert additional controls
addFilter(
	'editor.BlockEdit',
	'knight-blocks/columns/add-controls',
	addControls,
);

// add elements
addFilter(
	'blocks.getSaveElement',
	'knight-blocks/columns/add-elements',
	addElements
);