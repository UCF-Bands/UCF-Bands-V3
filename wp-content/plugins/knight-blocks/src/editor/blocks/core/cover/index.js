/**
 * Add cover features
 *
 * @since 1.0.0
 */

import './style.css';

import hasBlockStyle from '../../../util/has-block-style';

import classnames from 'classnames/dedupe';
import assign from 'lodash/assign';

const { __ } = wp.i18n;
const { registerBlockStyle } = wp.blocks;
const { addFilter } = wp.hooks;
const { createHigherOrderComponent } = wp.compose;
const { InspectorControls } = wp.blockEditor;
const { ToggleControl, PanelBody } = wp.components;

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

		kbFormBottomOffset: {
			type: 'boolean',
			default: false,
		},

		kbDidAutoSet: {
			type: 'boolean',
			default: false,
		},
	} );

	return settings;
};

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

		// AUTOMATICALLY RUNNING ALL THIS SETATTRIBUTES STUFF IS CAUSING
		// POST EDITS THAT THE EDITOR WANTS TO SAVE!! see wp.data.select('core/editor').getPostEdits!

		const { attributes, setAttributes } = props,
			{
				align,
				className,
				kbCenterChildren,
				kbFormBottomOffset,
				kbDidAutoSet,
			} = attributes,
			controls = [];

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
		controls.push(
			<ToggleControl
				key="center-children"
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

		// Bottom form offset
		controls.push(
			<ToggleControl
				key="form-bottom-offset"
				label={ __( 'Add bottom form offset/overlap' ) }
				checked={ kbFormBottomOffset }
				onChange={ ( value ) =>
					setAttributes( { kbFormBottomOffset: value } )
				}
			/>
		);

		/**
		 * @todo figure out why we can't get more props in <BlockEdit>
		 *
		 * Having all this setAttributes() stuff running causes the editor to
		 * always have a pending update/change and warns users when they try to
		 * leave, even if they didn't do anything.
		 *
		 * @see  https://github.com/WordPress/gutenberg/issues/20849
		 * @see  button block where it works, but it goes into the textarea
		 */
		const editProps = {
			...props,
			// attributes: {
			// 	...attributes,
			// 	className: classnames( className, {
			// 		'kb-center-children': kbCenterChildren,
			// 	} ),
			// },
			// OR
			// className: classnames( className, {
			// 	'kb-center-children': kbCenterChildren,
			// } ),
		};

		// give back original <BlockEdit> with custom inspector controls
		return (
			<div
				className={ classnames(
					'kb-editor-cover-wrap',
					{ 'kb-center-children': kbCenterChildren },
					{ 'kb-form-bottom-offset': kbFormBottomOffset }
				) }
				data-align={ align }
			>
				<BlockEdit { ...editProps } />

				<InspectorControls>
					<PanelBody title={ __( 'Layout', 'knight-blocks' ) }>
						{ controls }
					</PanelBody>
				</InspectorControls>
			</div>
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

	const { kbCenterChildren, kbFormBottomOffset } = attributes;

	// always add bulleted-list + some other conditional classes
	props.className = classnames( props.className, {
		'kb-center-children': kbCenterChildren,
		'kb-form-bottom-offset': kbFormBottomOffset,
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
