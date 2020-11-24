/**
 * Ordered process item block
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

import './style.scss';
import './editor.scss';

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
		__( 'ordered' ),
		__( 'step' ),
		__( 'process' ),
	],

	parent: [ 'knight-blocks/ordered-process' ],

	attributes: {
		status: {
			type: 'string',
			default: 'pending', // active, inactive
		},

		title: {
			type: 'string',
		},

		description: {
			type: 'html',
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
