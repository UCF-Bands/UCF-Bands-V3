/**
 * Add cover features
 *
 * @since   1.0.0
 * @package knight-blocks
 */

// import './style.scss';
// import './editor.scss';

import hasBlockStyle from '../../../util/has-block-style';

import classnames from 'classnames/dedupe';
import assign from 'lodash/assign';

const { __ } = wp.i18n;
const { registerBlockStyle } = wp.blocks;
const { addFilter } = wp.hooks;
const { createHigherOrderComponent } = wp.compose;
const { InspectorControls } = wp.blockEditor;
const { TextControl, ToggleControl, PanelBody } = wp.components;

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
 * @param  {object}  settings  current block settings
 * @param  {string}  name      current block name
 * @return {object}            modified block settings
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

		kbBottomCover: {
			type: 'number',
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
 * @param  {function}  BlockEdit  existing advanced inspector components
 * @return {object}               new advanced inspector controls
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

		const
			{ attributes, setAttributes } = props,
			{
				align,
				className,
				overlayColor,
				gradient,
				gradientAutoSet,
				kbCenterChildren,
				kbBottomCover,
			} = attributes,
			controls = [];

		// set if we're "banner" or "jumbo" block style
		const
			isBanner = hasBlockStyle( className, 'banner' ),
			isJumbo = hasBlockStyle( className, 'jumbo' );

		// if it's banner or jumbo and there isn't already a gradient or solid
		// overlay, automatically switch the gradient to "dark-gray-overlay-to-right"
		if (
			( isBanner || isJumbo ) &&
			( ! gradientAutoSet && ! gradient && ! overlayColor )
		) {
			setAttributes( {
				gradientAutoSet: true,
				gradient: 'dark-gray-overlay-to-right',
			} );

		// if we're at the default style now and we're coming from the
		// dark-gray-overlay-to-right gradient, set the overlay/gradient back to default
		} else if (
			( ! isBanner && ! isJumbo ) &&
			( gradient === 'dark-gray-overlay-to-right' )
		) {
			setAttributes( {
				gradientAutoSet: false,
				gradient: null,
			} );
		}

		// Center align columns control
		controls.push( <ToggleControl
			key="center-children"
			label={ __( 'Center-align columns', 'knight-blocks' ) }
			help={ __( 'Does not support wide/full columns.', 'knight-blocks' ) }
			checked={ kbCenterChildren }
			onChange={ ( value ) => setAttributes( { kbCenterChildren: value } ) }
		/> );

		// Bottom cover height control
		controls.push( <TextControl
			key="bottom-cover-height"
			label={ __( 'Bottom Crop (px)', 'knight-blocks' ) }
			type="number"
			value={ kbBottomCover }
			min="0"
			onChange={ ( value ) => setAttributes( { kbBottomCover: Number( value ) } ) }
		/> );

		// add conditional classes
		setAttributes( {
			className: classnames( props.attributes.className, {
				'kb-center-children': kbCenterChildren,
			} ),
		} );

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
			<div className="kb-editor-cover-wrap" data-align={ align }>

				{ kbBottomCover &&
					<div
						className="kb-cover-bottom-cover"
						style={ {
							height: `${ kbBottomCover }px`,
						} }
					/>
				}

				<BlockEdit { ...editProps } />

				<InspectorControls>
					<PanelBody title={ __( 'Layout', 'knight-blocks' ) }>{ controls }</PanelBody>
				</InspectorControls>
			</div>
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
 *
 * @since  1.0.0
 */
const addClasses = ( props, blockType, attributes ) => {
	if ( ! isCover( blockType.name ) ) {
		return props;
	}

	const { kbCenterChildren } = attributes;

	// always add bulleted-list + some other conditional classes
	props.className = classnames( props.className, {
		'kb-center-children': kbCenterChildren,
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
 * @param  {object}  element     block element (react.element)
 * @param  {object}  blockType   block type information
 * @param  {object}  attributes  block attributes
 * @return {object}  element
 */
const addElements = ( element, blockType, attributes ) => {
	if ( ! element || ! isCover( blockType.name ) ) {
		return element;
	}

	const { children, className, style } = element.props;
	const { kbBottomCover } = attributes;

	return (
		<div className={ className } style={ style }>

			{ /* bottom pseudo-crop cover thing */ }
			{ kbBottomCover &&
				<div
					className="kb-cover-bottom-cover"
					style={ {
						height: `${ kbBottomCover }px`,
					} }
				/>
			}

			{ /* inner blocks */ }
			{ children }
		</div>
	);
};

// add the attributes
addFilter(
	'blocks.registerBlockType',
	'knight-blocks/cover/add-attributes',
	addAttributes,
);

// insert the inspector controls
addFilter(
	'editor.BlockEdit',
	'knight-blocks/cover/add-controls',
	addControls,
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
