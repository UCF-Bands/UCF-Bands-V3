// If the page ISN'T a child, allow the selection of a menu
// if the page IS a child, get the section banner meta with the menu ID and load it in that way.

// Fields:
// if not inheriting, the "shared" inner blocks for title/subtitle
// if not inheriting, a navigation menu
// if not inheriting, a event band category or whatever
// block-specific CTA (inner block, or just "static"?)

// dynamic-banner-shared
// InnerBlocks will be specific to this block and not be inherited

/**
 * Dynamic banner block
 *
 * This banner dynamically inherits its top-level parent's section block's
 * "shared" inner blocks, navigation menu, and upcoming event. If the current
 * post is a parent post or it's a child with a parent that doesn't have a
 * section block, it's able to edit the "shared" blocks, choose a nav menu, etc
 * for it to potentially be inherited by a child.
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

import { cover as icon } from '@wordpress/icons';

import edit from './edit';
import save from './save';

// fix icon size (not sure why this is required)
icon.props.width = 24;
icon.props.height = 24;

/**
 * Register dynamic banner
 *
 * @link   https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/dynamic-banner', {
	title: __( 'Dynamic Banner', 'knight-blocks' ),
	description: __(
		'A cover-like banner that inherits its top-level parent\'s dynamic banner\'s contents.',
		'knight-blocks'
	),
	icon,
	category: 'design',
	keywords: [
		__( 'banner' ),
		__( 'cover' ),
		__( 'section header' ),
	],

	supports: {
		align: [ 'full' ],
	},

	attributes: {
		align: {
			type: 'string',
			default: 'full',
		},

		sharedCover: {
			type: 'array',
		},
	},

	edit,
	save,
} );
