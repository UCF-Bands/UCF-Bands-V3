/**
 * Add individual column-specific block features
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
const isColumn = ( name ) => {
	return name === 'core/column';
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
 * @since 1.0.0
 *
 * @param  {Function}  BlockEdit  existing advanced inspector components
 * @return {Object}               new advanced inspector controls
 */
const addControls = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		if ( ! isColumn( props.name ) ) {
			return <BlockEdit { ...props } />;
		}

		// get attribute helpers, attributes
		const { attributes, setAttributes } = props,
			{ kbTopSpacing } = attributes,
			controls = [];

		// Top spacing control
		controls.push(
			<SelectControl
				key="top-spacing"
				label={ __( 'Top Spacing', 'knight-blocks' ) }
				help={ __(
					'Add padding to top for form/media offsets.',
					'knight-blocks'
				) }
				options={ [
					{ label: __( 'None', 'knight-blocks' ), value: '' },
					{ label: __( 'Medium', 'knight-blocks' ), value: 'medium' },
				] }
				value={ kbTopSpacing }
				onChange={ ( value ) =>
					setAttributes( { kbTopSpacing: value } )
				}
			/>
		);

		return (
			<Fragment>
				<InspectorControls>
					<PanelBody title={ __( 'Spacing', 'knight-blocks' ) }>
						{ controls }
					</PanelBody>
				</InspectorControls>

				{ /* since we can't extend props.className */ }
				{ kbTopSpacing && (
					<div
						className={ `kb-column-top-spacing-${ kbTopSpacing }` }
					/>
				) }

				<BlockEdit { ...props } />
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
	addAttributes
);

// insert additional controls
addFilter(
	'editor.BlockEdit',
	'knight-blocks/column/add-controls',
	addControls
);

// conditionally add classes to block wrapper
addFilter(
	'blocks.getSaveContent.extraProps',
	'knight-blocks/column/add-classes',
	addClasses
);
