/**
 * Side-captioned gallery item
 *
 * @since 1.0.0
 */

import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { image as icon } from '@wordpress/icons';

import edit from './edit';

import './style.css';
import './editor.css';

/**
 * Register compact CTA card
 *
 * {@link https://wordpress.org/gutenberg/handbook/block-api/}
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/side-caption-gallery-item', {
	apiVersion: 2,
	title: __( 'Side-Captioned Gallery Item', 'knight-blocks' ),
	description: __(
		'An image, gallery, or video item in a side-captioned gallery',
		'knight-blocks'
	),
	icon,
	category: 'media',
	keywords: [ __( 'gallery' ), __( 'image' ), __( 'media' ) ],

	parent: [ 'knight-blocks/side-caption-gallery' ],

	attributes: {
		// caption heading
		heading: {
			type: 'string',
			default: __( 'What this thing is', 'knight-blocks' ),
		},

		// caption body
		caption: {
			type: 'string',
			default: __(
				'Describe the linked media with this caption.',
				'knight-blocks'
			),
		},

		// thumbnail attachment (also image if image type)
		thumbID: {
			type: 'number',
			default: 0,
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
