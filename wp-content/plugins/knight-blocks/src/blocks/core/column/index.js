/**
 * Add individual column-specific block features
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
const { PanelBody, SelectControl } = wp.components;

// sanity checker
const isColumn = ( name ) => {
	return name === 'core/column';
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
	if ( ! isColumn( name ) ) {
		return settings;
	}

	// use Lodash's assign to gracefully handle if attrs are undefined
	settings.attributes = assign( settings.attributes, {

		kbTopSpacing: {
			type: 'string',
			default: '',
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
		if ( ! isColumn( props.name ) ) {
			return <BlockEdit { ...props } />;
		}

		// get attribute helpers, attributes
		const
			{ attributes, setAttributes } = props,
			{ kbTopSpacing } = attributes,
			controls = [];

		// Top spacing control
		controls.push( <SelectControl
			key="top-spacing"
			label={ __( 'Top Spacing', 'knight-blocks' ) }
			help={ __( 'Add padding to top for form/media offsets.', 'knight-blocks' ) }
			options={ [
				{ label: __( 'None', 'knight-blocks' ), value: '' },
				{ label: __( 'Medium', 'knight-blocks' ), value: 'medium' },
			] }
			value={ kbTopSpacing }
			onChange={ ( value ) => setAttributes( { kbTopSpacing: value } ) }
		/> );

		return (
			<Fragment>
				<InspectorControls>
					<PanelBody title={ __( 'Spacing', 'knight-blocks' ) }>{ controls }</PanelBody>
				</InspectorControls>

				{ /* since we can't extend props.className */ }
				{ kbTopSpacing &&
					<div className={ `kb-column-top-spacing-${ kbTopSpacing }` } />
				}

				<BlockEdit { ...props } />
			</Fragment>
		);
	};
}, 'addControls' );

/**
 * Add classes for custom features to block
 *
 * @param  {object}  props       block properties
 * @param  {object}  blockType   block type/registration details
 * @param  {object}  attributes  block's attributes
 * @return {object}  props
 * @since  1.0.0
 */
const addClasses = ( props, blockType, attributes ) => {
	const { kbTopSpacing } = attributes;

	if ( ! isColumn( blockType.name ) ) {
		return props;
	}

	// conditionally add custom classes in addition to existing props
	props.className = classnames( props.className, {
		[ `kb-column-top-spacing-${ kbTopSpacing }` ]: kbTopSpacing,
	} );

	return props;
};

// add the attributes
addFilter(
	'blocks.registerBlockType',
	'knight-blocks/column/add-attributes',
	addAttributes,
);

// insert additional controls
addFilter(
	'editor.BlockEdit',
	'knight-blocks/column/add-controls',
	addControls,
);

// conditionally add classes to block wrapper
addFilter(
	'blocks.getSaveContent.extraProps',
	'knight-blocks/column/add-classes',
	addClasses
);