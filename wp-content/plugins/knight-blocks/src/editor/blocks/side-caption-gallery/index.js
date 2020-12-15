/**
 * Side-captioned gallery block
 *
 * @since 1.0.0
 */

import './style.css';
import './editor.css';

import { gallery as icon } from '@wordpress/icons';

import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks } from '@wordpress/block-editor';

const BLOCKS_TEMPLATE = [
	[ 'knight-blocks/side-caption-gallery-item' ],
	[ 'knight-blocks/side-caption-gallery-item' ],
	[ 'knight-blocks/side-caption-gallery-item' ],
	[ 'knight-blocks/side-caption-gallery-item' ],
];

const ALLOWED_BLOCKS = [ 'knight-blocks/side-caption-gallery-item' ];

/**
 * Register side-captioned gallery block.
 *
 * {@link https://wordpress.org/gutenberg/handbook/block-api/}
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/side-caption-gallery', {
	title: __( 'Side-Captioned Gallery' ),
	icon,
	category: 'media',
	keywords: [ __( 'gallery' ), __( 'image' ), __( 'video' ) ],

	supports: {
		align: [ 'wide', 'full' ],
	},

	attributes: {
		align: {
			type: 'string',
			default: 'full',
		},
	},

	/**
	 * Block edit
	 *
	 * @return {Object}  JSX Component.
	 */
	edit: () => {
		return (
			<InnerBlocks
				template={ BLOCKS_TEMPLATE }
				allowedBlocks={ ALLOWED_BLOCKS }
				orientation="horizontal"
			/>
		);
	},

	/**
	 * Block save
	 *
	 * @return {Object}  JSX Frontend HTML.
	 */
	save: () => {
		return (
			<section>
				<InnerBlocks.Content />
			</section>
		);
	},
} );
