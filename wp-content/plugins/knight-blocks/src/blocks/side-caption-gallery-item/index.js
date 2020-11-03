/**
 * Side-captioned gallery item
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

// import './style.scss';
// import './editor.scss';

import edit from './edit';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

/**
 * Register compact CTA card
 *
 * @link   https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/side-caption-gallery-item', {
	title: __( 'Side-Captioned Gallery Item', 'knight-blocks' ),
	description: __(
		'An image, gallery, or video item in a side-captioned gallery',
		'knight-blocks'
	),
	icon: 'format-gallery',
	category: 'media',
	keywords: [
		__( 'gallery' ),
		__( 'image' ),
		__( 'media' ),
	],

	attributes: {
		// caption heading
		heading: {
			type: 'string',
			default: __( 'What this thing is', 'knight-blocks' ),
		},

		// caption body
		caption: {
			type: 'string',
			default: __( 'Describe the linked media with this caption.', 'knight-blocks' ),
		},

		// thumbnail attachment (also image if image type)
		thumbID: {
			type: 'number',
		},

		// thumbnail preview
		thumbPreview: {
			type: 'string',
		},

		// media handling + icon
		type: {
			type: 'string',
			default: 'image', // image, image-gallery, or video
		},

		// external URL (ex: image gallery)
		url: {
			type: 'string',
		},
	},

	edit,
	save: () => null,
} );
