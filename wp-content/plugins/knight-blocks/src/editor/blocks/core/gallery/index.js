/**
 * Add gallery-specific features to block
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
import { PanelBody, ToggleControl } from '@wordpress/components';

import './style.css';
import './editor.css';

// sanity checker
const isGallery = ( name ) => {
	return name === 'core/gallery';
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
	if ( ! isGallery( name ) ) {
		return settings;
	}

	// use Lodash's assign to gracefully handle if attrs are undefined
	settings.attributes = assign( settings.attributes, {
		kbDisableItemGrow: {
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
 * @since 1.0.0
 *
 * @param  {Function}  BlockEdit  existing advanced inspector components
 * @return {Object}               new advanced inspector controls
 */
const addControls = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		if ( ! isGallery( props.name ) ) {
			return <BlockEdit { ...props } />;
		}

		const { attributes, setAttributes } = props,
			{ kbDisableItemGrow } = attributes;

		return (
			<Fragment>
				<div
					className={ classnames( {
						'kb-disable-item-grow': kbDisableItemGrow,
					} ) }
				>
					<BlockEdit { ...props } />
				</div>

				<InspectorControls>
					<PanelBody title={ __( 'Item sizing', 'knight-blocks' ) }>
						<ToggleControl
							label={ __(
								'Disable last row item "grow"',
								'knight-blocks'
							) }
							checked={ kbDisableItemGrow }
							onChange={ ( value ) =>
								setAttributes( { kbDisableItemGrow: value } )
							}
						/>
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
	const { kbDisableItemGrow } = attributes;

	if ( ! isGallery( blockType.name ) ) {
		return props;
	}

	// conditionally add custom classes in addition to existing props
	props.className = classnames( props.className, {
		'kb-disable-item-grow': kbDisableItemGrow,
	} );

	return props;
};

// add the attributes
addFilter(
	'blocks.registerBlockType',
	'knight-blocks/gallery/add-attributes',
	addAttributes
);

// insert the inspector controls
addFilter(
	'editor.BlockEdit',
	'knight-blocks/gallery/add-controls',
	addControls
);

// conditionally add classes to block wrapper
addFilter(
	'blocks.getSaveContent.extraProps',
	'knight-blocks/gallery/add-classes',
	addClasses
);
