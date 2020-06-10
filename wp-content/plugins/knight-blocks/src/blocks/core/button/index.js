/**
 * Add button-specific features to block
 *
 * @since   1.0.0
 * @package knight-blocks
 */

import classnames from 'classnames';
import assign from 'lodash/assign';

const { __ } = wp.i18n;
const { addFilter } = wp.hooks;
const { InspectorControls } = wp.blockEditor;
const { createHigherOrderComponent } = wp.compose;
const { PanelBody, SelectControl } = wp.components;

// sanity checker
const isButton = ( name ) => {
	return name === 'core/button';
};

/**
 * Add custom attributes to block
 *
 * @param  {object}  settings  current block settings
 * @param  {string}  name      current block name
 * @return {object}            modified block settings
 * @since  1.0.0
 */
const addAttributes = ( settings, name ) => {
	if ( ! isButton( name ) ) {
		return settings;
	}

	// use Lodash's assign to gracefully handle if attrs are undefined
	settings.attributes = assign( settings.attributes, {
		kbSize: {
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
		if ( ! isButton( props.name ) ) {
			return <BlockEdit { ...props } />;
		}

		const
			{ attributes, setAttributes } = props,
			{ kbSize } = attributes,
			controls = [];

		controls.push( <SelectControl
			key="size"
			label={ __( 'Size', 'knight-blocks' ) }
			options={ [
				{ label: __( 'Normal' ), value: '' },
				{ label: __( 'Large' ), value: 'large' },
			] }
			value={ kbSize }
			onChange={ ( value ) => setAttributes( { kbSize: value } ) }
		/> );

		// it looks like we have to add block "wrapper" classes with the outer
		// div since the extraProps thing only applies to save :(
		return (
			<span className={ classnames( {
				[ `child-has-theme-size-${ kbSize }` ]: kbSize,
			} ) }>

				<BlockEdit { ...props } />

				<InspectorControls>
					<PanelBody title={ __( 'Size settings', 'knight-blocks' ) }>{ controls }</PanelBody>
				</InspectorControls>

			</span>
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
	const { kbSize } = attributes;

	if ( ! isButton( blockType.name ) ) {
		return props;
	}

	// conditionally add custom classes in addition to existing props
	props.className = classnames( props.className, {
		[ `has-theme-size-${ kbSize }` ]: kbSize,
	} );

	return props;
};

// add the attributes
addFilter(
	'blocks.registerBlockType',
	'knight-blocks/button/add-attributes',
	addAttributes,
);

// insert the inspector controls
addFilter(
	'editor.BlockEdit',
	'knight-blocks/button/add-controls',
	addControls,
);

// conditionally add classes to block wrapper
addFilter(
	'blocks.getSaveContent.extraProps',
	'knight-blocks/button/add-classes',
	addClasses
);
