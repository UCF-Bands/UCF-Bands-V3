/**
 * Add columns-specific block features
 *
 * Add wrapper + other settings to the core/columns block.
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
import { PanelBody, RadioControl, ToggleControl } from '@wordpress/components';

// sanity checker
const isColumns = ( name ) => {
	return name === 'core/columns';
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
	if ( ! isColumns( name ) ) {
		return settings;
	}

	// use Lodash's assign to gracefully handle if attrs are undefined
	settings.attributes = assign( settings.attributes, {
		kbSpacing: {
			type: 'string',
			default: '',
		},

		kbVSpacing: {
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
 * @since 1.0.0
 *
 * @param  {Function}  BlockEdit  existing advanced inspector components
 * @return {Object}               new advanced inspector controls
 */
const addControls = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		if ( ! isColumns( props.name ) ) {
			return <BlockEdit { ...props } />;
		}

		// get attribute helpers, attributes
		const { attributes, setAttributes } = props,
			{ align, kbSpacing, kbVSpacing, kbReverse } = attributes,
			controls = [];

		// Horizontal spacing control
		controls.push(
			<RadioControl
				key="horizontal-spacing"
				label={ __( 'Horizontal Spacing', 'knight-blocks' ) }
				options={ [
					{ label: __( 'None', 'knight-blocks' ), value: 'none' },
					{ label: __( 'Medium', 'knight-blocks' ), value: 'medium' },
					{ label: __( 'Default', 'knight-blocks' ), value: '' },
				] }
				onChange={ ( value ) => setAttributes( { kbSpacing: value } ) }
				selected={ kbSpacing }
			/>
		);

		// Vertical spacing control
		controls.push(
			<RadioControl
				key="vertical-spacing"
				label={ __( 'Vertical Spacing', 'knight-blocks' ) }
				options={ [
					{ label: __( 'Medium', 'knight-blocks' ), value: 'medium' },
					{ label: __( 'Default', 'knight-blocks' ), value: '' },
				] }
				onChange={ ( value ) => setAttributes( { kbVSpacing: value } ) }
				selected={ kbVSpacing }
			/>
		);

		// Reverse mobile order control
		controls.push(
			<ToggleControl
				key="reverse-order"
				label={ __( 'Reverse mobile column order', 'knight-blocks' ) }
				help={ __(
					'Stack the right column above the left on smaller screens.',
					'knight-blocks'
				) }
				checked={ kbReverse }
				onChange={ ( value ) => setAttributes( { kbReverse: value } ) }
			/>
		);

		// give back original <BlockEdit> with our new wrapper
		// .wp-block is for spacing/margins, data-align for max-width
		return (
			<Fragment>
				<InspectorControls>
					<PanelBody
						title={ __( 'Spacing & Order', 'knight-blocks' ) }
					>
						{ controls }
					</PanelBody>
				</InspectorControls>

				<div
					className={ classnames( {
						'wp-block': true,
						'kb-columns-wrap': true,
						[ `kb-columns-spacing-${ kbSpacing }` ]: kbSpacing,
						[ `kb-columns-v-spacing-${ kbVSpacing }` ]: kbVSpacing,
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
 * @since 1.0.0
 *
 * @param  {Object}  element     block element (react.element)
 * @param  {Object}  blockType   block type information
 * @param  {Object}  attributes  block attributes
 * @return {Object}  element
 */
const addElements = ( element, blockType, attributes ) => {
	if ( ! element || ! isColumns( blockType.name ) ) {
		return element;
	}

	const { children, className, style } = element.props;
	const { align, kbSpacing, kbVSpacing, kbReverse } = attributes;

	return (
		// our new wrapper with alignment class
		<div
			className={ classnames( {
				'kb-columns-wrap': true,
				[ `kb-columns-spacing-${ kbSpacing }` ]: kbSpacing,
				[ `kb-columns-v-spacing-${ kbVSpacing }` ]: kbVSpacing,
				[ `align${ align }` ]: align,
				'fa-mobile-reverse-order': kbReverse,
			} ) }
		>
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
	addAttributes
);

// insert additional controls
addFilter(
	'editor.BlockEdit',
	'knight-blocks/columns/add-controls',
	addControls
);

// add elements
addFilter(
	'blocks.getSaveElement',
	'knight-blocks/columns/add-elements',
	addElements
);
