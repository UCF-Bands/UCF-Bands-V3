/**
 * Add features to list block
 *
 * @since   1.0.0
 * @package knight-blocks
 */

import classnames from 'classnames';

const { addFilter } = wp.hooks;

const isList = ( name ) => {
	return name === 'core/list';
};

/**
 * Add classes for custom features to block
 *
 * @param  {object}  props       block properties
 * @param  {object}  blockType   block type/registration details
 * @return {object}  props
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
