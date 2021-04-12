/**
 * Add features to list block
 *
 * @since 1.0.0
 */

import classnames from 'classnames';

import { addFilter } from '@wordpress/hooks';

const isList = ( name ) => {
	return name === 'core/list';
};

/**
 * Add classes for custom features to block
 *
 * @since 1.0.0
 *
 * @param  {Object}  props       block properties
 * @param  {Object}  blockType   block type/registration details
 * @param  {Object}  attributes  block attributes
 * @return {Object}  props
 */
const addClasses = ( props, blockType, attributes ) => {
	if ( ! isList( blockType.name ) ) {
		return props;
	}

	// always add bulleted-list
	props.className = classnames( props.className, {
		'bulleted-list': ! attributes.ordered,
	} );

	return props;
};

// Add classes to block wrapper
addFilter(
	'blocks.getSaveContent.extraProps',
	'knight-blocks/list/add-classes',
	addClasses
);
