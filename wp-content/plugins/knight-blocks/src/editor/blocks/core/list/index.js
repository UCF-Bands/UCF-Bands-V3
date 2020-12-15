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
 * @param  {Object}  props       block properties
 * @param  {Object}  blockType   block type/registration details
 * @return {Object}  props
 * @since  1.0.0
 */
const addClasses = ( props, blockType ) => {
	if ( ! isList( blockType.name ) ) {
		return props;
	}

	// always add bulleted-list
	props.className = classnames( props.className, {
		'bulleted-list': props.tagName === 'ul',
	} );

	return props;
};

// Add classes to block wrapper
addFilter(
	'blocks.getSaveContent.extraProps',
	'knight-blocks/list/add-classes',
	addClasses
);
