/**
 * Icon and details block
 *
 * @since 1.0.0
 */

import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { mediaAndText as icon } from '@wordpress/icons';

import edit from './edit';
import save from './save';

import './style.css';
import './editor.css';

const iconSelector = '.icon-and-details-icon img';

/**
 * Register icon and details
 *
 * {@link https://wordpress.org/gutenberg/handbook/block-api/}
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/icon-and-details', {
	apiVersion: 2,
	title: __( 'Icon and Details', 'knight-blocks' ),
	description: __( 'Small image paired with brief content', 'knight-blocks' ),
	icon,
	category: 'design',
	keywords: [ __( 'audition' ), __( 'icon' ), __( 'list' ), __( 'details' ) ],

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
