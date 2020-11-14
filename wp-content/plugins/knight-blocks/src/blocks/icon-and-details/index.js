/**
 * Icon and details block
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

// import './style.scss';
// import './editor.scss';

import { mediaAndText as icon } from '@wordpress/icons';

import edit from './edit';
import save from './save';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

const iconSelector = '.icon-and-details-icon img';

/**
 * Register icon and details
 *
 * @link   https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/icon-and-details', {
	title: __( 'Icon and Details', 'knight-blocks' ),
	description: __(
		'Small image paired with brief content',
		'knight-blocks'
	),
	icon,
	category: 'design',
	keywords: [
		__( 'audition' ),
		__( 'icon' ),
		__( 'list' ),
		__( 'details' ),
	],

	attributes: {
		iconID: {
			type: 'string',
			source: 'attribute',
			selector: iconSelector,
			attribute: 'data-attachment',
		},

		iconSrc: {
			type: 'string',
			source: 'attribute',
			selector: iconSelector,
			attribute: 'src',
		},

		iconAlt: {
			type: 'string',
			source: 'attribute',
			selector: iconSelector,
			attribute: 'alt',
		},
	},

	edit,
	save,
} );
