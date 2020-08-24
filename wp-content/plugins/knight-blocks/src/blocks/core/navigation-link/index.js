/**
 * Add navigation link block features
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

import assign from 'lodash/assign';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

const { __ } = wp.i18n;
const { addFilter } = wp.hooks;
const { createHigherOrderComponent } = wp.compose;
const { InspectorControls } = wp.blockEditor;
const { Fragment } = wp.element;
const { TextControl, PanelBody } = wp.components;

// sanity checker
const isLink = ( name ) => {
	return name === 'core/navigation-link';
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
	if ( ! isLink( name ) ) {
		return settings;
	}

	// use Lodash's assign to gracefully handle if attrs are undefined
	settings.attributes = assign( settings.attributes, {
		kbIconName: {
			type: 'string',
			source: 'attribute',
			selector: '.far',
			attribute: 'data-icon',
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
		if ( ! isLink( props.name ) ) {
			return <BlockEdit { ...props } />;
		}

		const
			{ attributes, setAttributes } = props,
			{ kbIconName } = attributes;

		const viewIcons = <a
			href="https://fontawesome.com/icons?d=gallery&s=regular"
			target="_blank"
			rel="noopener noreferrer"
		>{ __( 'View Icons', 'knight-blocks' ) }</a>;

		const iconNameControl = <TextControl
			label={ __( 'Font Awesome Icon Name', 'knight-blocks' ) }
			placeholder={ __( 'Ex: rocket', 'knight-blocks' ) }
			help={ viewIcons }
			onChange={ ( value ) => setAttributes( { kbIconName: value } ) }
			value={ kbIconName }
		/>;

		return (
			<Fragment>
				<FontAwesomeIcon icon={ [ 'far', kbIconName ? kbIconName : 'circle' ] } />

				<BlockEdit { ...props } />

				<InspectorControls>
					<PanelBody title={ __( 'Banner link settings', 'knight-blocks' ) }>
						{ iconNameControl }
					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	};
}, 'addControls' );

// /**
//  * Add classes for custom features to block
//  *
//  * @param  {object}  props       block properties
//  * @param  {object}  blockType   block type/registration details
//  * @param  {object}  attributes  block's attributes
//  * @return {object}  props
//  * @since  1.0.0
//  */
// const addClasses = ( props, blockType, attributes ) => {
// 	const { kbIconName } = attributes;

// 	if ( ! isLink( blockType.name ) ) {
// 		return props;
// 	}

// 	// conditionally add custom classes in addition to existing props
// 	props.className = classnames( props.className, {
// 		[ `has-size-${ kbIconName }` ]: kbIconName,
// 	} );

// 	return props;
// };

// add the attributes
addFilter(
	'blocks.registerBlockType',
	'knight-blocks/navigation-link/add-attributes',
	addAttributes,
);

// insert the inspector controls
addFilter(
	'editor.BlockEdit',
	'knight-blocks/navigation-link/add-controls',
	addControls,
);

// // conditionally add classes to block wrapper
// addFilter(
// 	'blocks.getSaveContent.extraProps',
// 	'knight-blocks/navigation-link/add-classes',
// 	addClasses
// );
