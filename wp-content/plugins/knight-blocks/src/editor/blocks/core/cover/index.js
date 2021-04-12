/**
 * Add cover features
 *
 * @todo  write blog about getting innerBlocks in core block? (find gist)
 *
 * @since 1.0.0
 */

import classnames from 'classnames/dedupe';
import assign from 'lodash/assign';

import { __ } from '@wordpress/i18n';
import { addFilter } from '@wordpress/hooks';
import { createHigherOrderComponent } from '@wordpress/compose';
import { InspectorControls } from '@wordpress/block-editor';
import { registerBlockStyle, registerBlockVariation } from '@wordpress/blocks';
import { ToggleControl, SelectControl, PanelBody } from '@wordpress/components';

import hasBlockStyle from '../../../util/has-block-style';
import textAndForm from '../../../patterns/text-and-form';
import announcements from '../../../patterns/announcements';

import './style.css';

// Register block styles
registerBlockStyle( 'core/cover', [
	{
		name: 'banner',
		label: __( 'Banner', 'knight-blocks' ),
		isDefault: false,
	},
	{
		name: 'condensed-banner',
		label: __( 'Condensed Banner', 'knight-blocks' ),
		isDefault: false,
	},
	{
		name: 'jumbo',
		label: __( 'Jumbo Banner', 'knight-blocks' ),
		isDefault: false,
	},
] );

// Register block variations
registerBlockVariation( 'core/cover', [
	{
		name: 'page-banner',
		title: __( 'Page Banner', 'knight-blocks' ),
		attributes: {
			align: 'full',
			gradient: 'dark-gray-overlay-to-right',
			className: 'is-style-banner',
			kbDidAutoSet: true,
		},
		innerBlocks: [
			[
				'core/heading',
				{ level: 1, content: __( 'Page Title', 'knight-blocks' ) },
			],
			[
				'core/paragraph',
				{
					className: 'is-style-featured',
					content: __(
						'Page Subtitle. Remember to set a background with "Add Media" above.',
						'knight-blocks'
					),
				},
			],
		],
	},
	{
		name: 'form',
		title: __( 'Cover with Form', 'knight-blocks' ),
		attributes: {
			align: 'full',
			gradient: 'dark-gray-overlay-to-right',
			kbBottomOffset: 'form',
		},
		innerBlocks: [ textAndForm ],
	},
	{
		name: 'announcements',
		title: __( 'Cover with Announcements', 'knight-blocks' ),
		attributes: {
			align: 'full',
			gradient: 'dark-gray',
		},
		innerBlocks: [ announcements ],
	},
] );

// sanity checker
const isCover = ( name ) => {
	return name === 'core/cover';
};

/**
 * Add custom attributes to block
 *
 * @param  {Object}  settings  current block settings
 * @param  {string}  name      current block name
 * @return {Object}            modified block settings
 *
 * @since  1.0.0
 */
const addAttributes = ( settings, name ) => {
	if ( ! isCover( name ) ) {
		return settings;
	}

	// use Lodash's assign to gracefully handle if attrs are undefined
	settings.attributes = assign( settings.attributes, {
		// really just for columns for now
		kbCenterChildren: {
			type: 'boolean',
			default: false,
		},

		kbBottomOffset: {
			type: 'string',
			default: '',
		},

		kbDidAutoSet: {
			type: 'boolean',
			default: false,
		},
	} );

	return settings;
};

/**
 * Manage "block list" block for cover
 *
 * We need this for the custom block classNames to work.
 *
 * @param  {Function}  BlockListBlock  Block list block component
 * @return {Function}  BlockListBlock  Adjusted block list block
 *
 * @since 1.0.0
 */
const blockListBlock = createHigherOrderComponent( ( BlockListBlock ) => {
	return ( props ) => {
		if ( ! isCover( props.name ) ) {
			return <BlockListBlock { ...props } />;
		}

		const {
			className,
			kbCenterChildren,
			kbBottomOffset,
		} = props.attributes;

		return (
			<BlockListBlock
				{ ...props }
				className={ classnames( className, {
					'kb-center-children': kbCenterChildren,
					[ `kb-${ kbBottomOffset }-bottom-offset` ]: kbBottomOffset,
				} ) }
			/>
		);
	};
}, 'blockListBlock' );

/**
 * Manage custom on-edit functionality for cover block
 *
 * We're watching for the block's style to change in case a default gradient
 * overlay needs to be set.
 *
 * @param  {Function}  BlockEdit  existing advanced inspector components
 * @return {Object}               new advanced inspector controls
 *
 * @since  1.0.0
 */
const addControls = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		if ( ! isCover( props.name ) ) {
			return <BlockEdit { ...props } />;
		}

		const { attributes, setAttributes } = props,
			{
				className,
				kbCenterChildren,
				kbBottomOffset,
				kbDidAutoSet,
			} = attributes;

		// set if we're "banner" or "jumbo" block style
		const isBanner = hasBlockStyle( className, 'banner' ),
			isJumbo = hasBlockStyle( className, 'jumbo' );

		// if it's banner or jumbo and there isn't already a gradient or solid
		// overlay, automatically switch the gradient to "dark-gray-overlay-to-right"
		if ( ( isBanner || isJumbo ) && ! kbDidAutoSet ) {
			setAttributes( {
				kbDidAutoSet: true,
				gradient: 'dark-gray-overlay-to-right',
			} );
		}

		// Center align columns control
		const centerChildrenControl = (
			<ToggleControl
				label={ __( 'Center-align columns', 'knight-blocks' ) }
				help={ __(
					'Does not support wide/full columns.',
					'knight-blocks'
				) }
				checked={ kbCenterChildren }
				onChange={ ( value ) =>
					setAttributes( { kbCenterChildren: value } )
				}
			/>
		);

		// Bottom offset
		const bottomOffsetControl = (
			<SelectControl
				label={ __( 'Bottom offset/overlap' ) }
				options={ [
					{ label: __( 'None' ), value: '' },
					{ label: __( 'Form' ), value: 'form' },
				] }
				value={ kbBottomOffset }
				onChange={ ( value ) =>
					setAttributes( { kbBottomOffset: value } )
				}
			/>
		);

		return (
			<>
				<BlockEdit { ...props } />
				<InspectorControls>
					<PanelBody title={ __( 'Layout', 'knight-blocks' ) }>
						{ centerChildrenControl }
						{ bottomOffsetControl }
					</PanelBody>
				</InspectorControls>
			</>
		);
	};
}, 'addControls' );

/**
 * Add classes for custom features to block
 *
 * @param  {Object}  props       block properties
 * @param  {Object}  blockType   block type/registration details
 * @param  {Object}  attributes  block's attributes
 * @return {Object}  props
 *
 * @since  1.0.0
 */
const addClasses = ( props, blockType, attributes ) => {
	if ( ! isCover( blockType.name ) ) {
		return props;
	}

	const { kbCenterChildren, kbBottomOffset } = attributes;

	// always add bulleted-list + some other conditional classes
	props.className = classnames( props.className, {
		'kb-center-children': kbCenterChildren,
		[ `kb-${ kbBottomOffset }-bottom-offset` ]: kbBottomOffset,
	} );

	return props;
};

/**
 * Add custom elements to existing block
 *
 * The outermost element being returned is basically us re-wrapping the outer
 * "cover" container, then put the children (nested blocks) and our custom stuff
 * inside.
 *
 * @param  {Object}  element     block element (react.element)
 * @param  {Object}  blockType   block type information
 * @return {Object}  element
 */
const addElements = ( element, blockType ) => {
	if ( ! element || ! isCover( blockType.name ) ) {
		return element;
	}

	const { children, className, style } = element.props;

	// put normally-inlined styles in its own div?
	const separateStyleNode = className.includes( 'is-dynamic-banner-cover' );

	return (
		<div className={ className } style={ separateStyleNode ? null : style }>
			{ separateStyleNode && (
				<div className="cover-style" style={ style } />
			) }

			{ /* inner blocks */ }
			{ children }
		</div>
	);
};

// add the attributes
addFilter(
	'blocks.registerBlockType',
	'knight-blocks/cover/add-attributes',
	addAttributes
);

// adjust block list block edit
addFilter(
	'editor.BlockListBlock',
	'knight-blocks/cover/block-list-block',
	blockListBlock
);

// insert the inspector controls
addFilter(
	'editor.BlockEdit',
	'knight-blocks/cover/add-controls',
	addControls
);

// conditionally add classes to block wrapper
addFilter(
	'blocks.getSaveContent.extraProps',
	'knight-blocks/cover/add-classes',
	addClasses
);

// add elements
addFilter(
	'blocks.getSaveElement',
	'knight-blocks/cover/add-elements',
	addElements
);
