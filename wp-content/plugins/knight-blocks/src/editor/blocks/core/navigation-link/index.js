/**
 * Add navigation link block features
 *
 * @todo    Kill this zombie?
 * @since 1.0.0
 */

import IconNameControl from '../../../components/icon-name-control';

import assign from 'lodash/assign';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

const { __ } = wp.i18n;
const { addFilter } = wp.hooks;
const { createHigherOrderComponent } = wp.compose;
const { InspectorControls } = wp.blockEditor;
const { Fragment } = wp.element;
const { PanelBody } = wp.components;

// sanity checker
const isLink = ( name ) => {
	return name === 'core/navigation-link';
};

/**
 * Add custom attributes to block
 *
 * @param  {Object}  settings  current block settings
 * @param  {string}  name      current block name
 * @return {Object}            modified block settings
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
 * @param  {Function}  BlockEdit  existing advanced inspector components
 * @return {Object}               new advanced inspector controls
 *
 * @since  1.0.0
 */
const addControls = createHigherOrderComponent( ( BlockEdit ) => {
	return ( props ) => {
		if ( ! isLink( props.name ) ) {
			return <BlockEdit { ...props } />;
		}

		const { attributes, setAttributes } = props,
			{ kbIconName } = attributes;

		return (
			<Fragment>
				<FontAwesomeIcon
					icon={ [ 'far', kbIconName ? kbIconName : 'circle' ] }
				/>

				<BlockEdit { ...props } />

				<InspectorControls>
					<PanelBody
						title={ __( 'Banner link settings', 'knight-blocks' ) }
					>
						<IconNameControl
							value={ kbIconName }
							onChange={ ( value ) =>
								setAttributes( { kbIconName: value } )
							}
						/>
					</PanelBody>
				</InspectorControls>
			</Fragment>
		);
	};
}, 'addControls' );

// add the attributes
addFilter(
	'blocks.registerBlockType',
	'knight-blocks/navigation-link/add-attributes',
	addAttributes
);

// insert the inspector controls
addFilter(
	'editor.BlockEdit',
	'knight-blocks/navigation-link/add-controls',
	addControls
);
