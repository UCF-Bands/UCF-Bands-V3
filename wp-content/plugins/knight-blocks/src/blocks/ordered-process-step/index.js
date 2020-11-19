/**
 * Ordered process item block
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

// import './style.scss';
// import './editor.scss';

import { formatListNumbered as icon } from '@wordpress/icons';

import edit from './edit';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

/**
 * Register ordered process step
 *
 * @link   https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/ordered-process-step', {
	title: __( 'Step', 'knight-blocks' ),
	description: __(
		'A step in an ordered process',
		'knight-blocks'
	),
	icon,
	category: 'design',
	keywords: [
		__( 'step' ),
		__( 'todo' ),
		__( 'process' ),
	],

	attributes: {
		status: {
			type: 'string',
			default: 'pending', // active, inactive
		},

		title: {
			type: 'string',
			// source: 'html',
			// selector: '.ordered-process-step-title',
		},

		description: {
			type: 'html',
			// source: 'html',
			// selector: '.ordered-process-step-description',
		},

		type: {
			type: 'string',
			default: 'static', // link, download?
		},

		url: {
			type: 'string',
		},
	},

	edit,
	save: () => null,
} );
