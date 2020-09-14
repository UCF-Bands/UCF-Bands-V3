/**
 * "Compact" CTA card
 *
 * Intended for dynamic banner block.
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

// import './style.scss';
// import './editor.scss';

import { button as icon } from '@wordpress/icons';

import edit from './edit';
import save from './save';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

// fix icon size (not sure why this is required)
icon.props.width = 24;
icon.props.height = 24;

/**
 * Register compact CTA card
 *
 * @link   https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/cta-card-compact', {
	title: __( 'Compact CTA Card', 'knight-blocks' ),
	description: __(
		'CTA card with heading and button',
		'knight-blocks'
	),
	icon,
	category: 'design',
	keywords: [
		__( 'CTA' ),
		__( 'button' ),
		__( 'card' ),
	],

	edit,
	save,
} );
