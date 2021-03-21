/**
 * Side-captioned gallery block
 *
 * @since 1.0.0
 */

import './style.css';
import './editor.css';

import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';
import { gallery as icon } from '@wordpress/icons';

const BLOCKS_TEMPLATE = [
	[ 'knight-blocks/side-caption-gallery-item' ],
	[ 'knight-blocks/side-caption-gallery-item' ],
	[ 'knight-blocks/side-caption-gallery-item' ],
	[ 'knight-blocks/side-caption-gallery-item' ],
];

const ALLOWED_BLOCKS = [ 'knight-blocks/side-caption-gallery-item' ];

/**
 * Block edit
 *
 * @return {Object}  JSX Component.
 */
const Edit = () => {
	return (
		<section { ...useBlockProps() }>
			<InnerBlocks
				template={ BLOCKS_TEMPLATE }
				allowedBlocks={ ALLOWED_BLOCKS }
				orientation="horizontal"
			/>
		</section>
	);
};

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
	apiVersion: 2,
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

	edit: Edit,

	/**
	 * Block save
	 *
	 * @return {Object}  JSX Frontend HTML.
	 */
	save: () => {
		return (
			<section { ...useBlockProps.save() }>
				<InnerBlocks.Content />
			</section>
		);
	},
} );
