/**
 * Dynamic banner "additional" content
 *
 * Navigation, CTA, and event portions of the dynamic banner block.
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

// Import CSS.
import './style.scss';
import './editor.scss';

import { cover as icon } from '@wordpress/icons';

import edit from './edit';
import save from './save';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

/**
 * Register dynamic banner additional content
 *
 * @link   https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/dynamic-banner-addl', {
	title: __( 'Dynamic Banner Additional Content', 'knight-blocks' ),
	description: __(
		'Dynamic banner navigation, CTA, and event contents',
		'knight-blocks'
	),
	icon,
	category: 'design',
	keywords: [
		__( 'dynamic banner' ),
		__( 'cover' ),
		__( 'section header' ),
	],

	parent: [ 'knight-blocks/dynamic-banner' ],

	attributes: {
		// future taxonomy
		ensemble: {
			type: 'number',
			source: 'meta',
			meta: '_dynamic_banner_ensemble',
		},
	},

	edit,
	save,
} );
