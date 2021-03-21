/**
 * Ordered process item block
 *
 * @since 1.0.0
 */

import './style.css';
import './editor.css';

import edit from './edit';

import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { formatListNumbered as icon } from '@wordpress/icons';

/**
 * Register ordered process step
 *
 * {@link https://wordpress.org/gutenberg/handbook/block-api/}
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/ordered-process-step', {
	apiVersion: 2,
	title: __( 'Step', 'knight-blocks' ),
	description: __( 'A step in an ordered process', 'knight-blocks' ),
	icon,
	category: 'design',
	keywords: [ __( 'ordered' ), __( 'step' ), __( 'process' ) ],

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
