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

// import edit from './edit';
// import save from './save';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { InnerBlocks } = wp.blockEditor;

// fix icon size (not sure why this is required)
icon.props.width = 24;
icon.props.height = 24;

const ALLOWED_BLOCKS = [
	'core/heading',
	'core/paragraph',
	'core/button',
];

const BLOCKS_TEMPLATE = [
	[
		'core/heading',
		{
			level: 4,
			placeholder: __( 'Marching Knights Enrollment Has Started', 'knight-blocks' ),
		},
	],
	[
		'core/paragraph',
		{
			placeholder: __( 'Paragraph can go here too.', 'knight-blocks' ),
		},
	],
	[ 'core/button', { kbSize: 'has-size-large' } ],
];

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

	// edit,
	edit: ( { className } ) => {
		return (
			<figure className={ className }>
				<InnerBlocks
					template={ BLOCKS_TEMPLATE }
					allowedBlocks={ ALLOWED_BLOCKS }
				/>
			</figure>
		);
	},

	// save,
	save: ( { className } ) => {
		return (
			<figure className={ className }>
				<InnerBlocks.Content />
			</figure>
		);
	},
} );
