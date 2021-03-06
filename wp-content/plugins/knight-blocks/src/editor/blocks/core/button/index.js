/**
 * Add button-specific features to block
 *
 * @since 1.0.0
 */

import classnames from 'classnames/dedupe';
import assign from 'lodash/assign';

import { __ } from '@wordpress/i18n';
import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { Fragment } from '@wordpress/element';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';

// sanity checker
const isButton = ( name ) => {
	return name === 'core/button';
};

/**
 * Add custom attributes to block
 *
 * @since 1.0.0
 *
 * @param  {Object}  settings  current block settings
 * @param  {string}  name      current block name
 * @return {Object}            modified block settings
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
 * @since 1.0.0
 *
 * @param  {Function}  BlockEdit  existing advanced inspector components
 * @return {Object}               new advanced inspector controls
 */
const addControls = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		if ( ! isButton( props.name ) ) {
			return <BlockEdit { ...props } />;
		}

		const { attributes, setAttributes } = props,
			{ kbSize } = attributes,
			controls = [];

		controls.push(
			<SelectControl
				key="size"
				label={ __( 'Size', 'knight-blocks' ) }
				options={ [
					{ label: __( 'Normal' ), value: '' },
					{ label: __( 'Large' ), value: 'large' },
				] }
				value={ kbSize }
				onChange={ ( value ) => setAttributes( { kbSize: value } ) }
			/>
		);

		return (
			<Fragment>
				<BlockEdit
					{ ...props }
					className={ classnames( {
						[ `has-size-${ kbSize }` ]: kbSize,
					} ) }
				/>

				<InspectorControls>
					<PanelBody title={ __( 'Size settings', 'knight-blocks' ) }>
						{ controls }
					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	};
}, 'addControls' );

/**
 * Add classes for custom features to block
 *
 * @since 1.0.0
 *
 * @param  {Object}  props       block properties
 * @param  {Object}  blockType   block type/registration details
 * @param  {Object}  attributes  block's attributes
 * @return {Object}  props
 */
const addClasses = ( props, blockType, attributes ) => {
	const { kbSize } = attributes;

	if ( ! isButton( blockType.name ) ) {
		return props;
	}

	// conditionally add custom classes in addition to existing props
	props.className = classnames( props.className, {
		[ `has-size-${ kbSize }` ]: kbSize,
	} );

	return props;
};

// add the attributes
addFilter(
	'blocks.registerBlockType',
	'knight-blocks/button/add-attributes',
	addAttributes
);

// insert the inspector controls
addFilter(
	'editor.BlockEdit',
	'knight-blocks/button/add-controls',
	addControls
);

// conditionally add classes to block wrapper
addFilter(
	'blocks.getSaveContent.extraProps',
	'knight-blocks/button/add-classes',
	addClasses
);
