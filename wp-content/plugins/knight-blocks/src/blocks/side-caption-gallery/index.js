/**
 * Side-captioned gallery block
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

// import './editor.scss';
// import './style.scss';

import { gallery as icon } from '@wordpress/icons';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { InnerBlocks } = wp.blockEditor;

const BLOCKS_TEMPLATE = [
	[ 'knight-blocks/side-caption-gallery-item' ],
	[ 'knight-blocks/side-caption-gallery-item' ],
	[ 'knight-blocks/side-caption-gallery-item' ],
	[ 'knight-blocks/side-caption-gallery-item' ],
];

const ALLOWED_BLOCKS = [
	'knight-blocks/side-caption-gallery-item',
];

/**
 * Register side-captioned gallery block.
 *
 * @link   https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/side-caption-gallery', {
	title: __( 'Side-Captioned Gallery' ),
	icon,
	category: 'media',
	keywords: [
		__( 'gallery' ),
		__( 'image' ),
		__( 'video' ),
	],

	/**
	 * Block edit
	 *
	 * @param   {Object} props Props.
	 * @returns {Mixed}  JSX Component.
	 */
	edit: ( props ) => {
		// const { attributes } = props;

		return (
			// <section>
			<InnerBlocks
				template={ BLOCKS_TEMPLATE }
				allowedBlocks={ ALLOWED_BLOCKS }
			/>
			// </section>
		);
	},

	/**
	 * Block save
	 *
	 * @param   {Object} props Props.
	 * @returns {Mixed}  JSX Frontend HTML.
	 */
	save: () => {
		return <section>
			<InnerBlocks.Content />;
		</section>;
	},
} );
