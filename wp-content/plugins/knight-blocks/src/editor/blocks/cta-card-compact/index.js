/**
 * "Compact" CTA card
 *
 * Intended for dynamic banner block.
 *
 * @since 1.0.0
 */

import './style.css';
import './editor.css';

import edit from './edit';
import save from './save';

import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { button as icon } from '@wordpress/icons';

/**
 * Register compact CTA card
 *
 * {@link https://wordpress.org/gutenberg/handbook/block-api/}
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/cta-card-compact', {
	title: __( 'Compact CTA Card', 'knight-blocks' ),
	description: __( 'CTA card with heading and button', 'knight-blocks' ),
	icon,
	category: 'design',
	keywords: [ __( 'CTA' ), __( 'button' ), __( 'card' ) ],

	attributes: {
		heading: {
			type: 'string',
			source: 'text',
			selector: '.cta-card-heading',
			default: __( 'Ex: Marching Knights Enrollment…', 'knight-blocks' ),
		},

		paragraph: {
			type: 'string',
			source: 'text',
			selector: 'p',
		},
	},

	edit,
	save,
} );
