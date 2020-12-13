/**
 * Products wrapper block
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

import './style.css';
import './editor.css';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { InnerBlocks } = wp.blockEditor;

const BLOCKS_TEMPLATE = [
	[ 'knight-blocks/product' ],
	[ 'knight-blocks/product' ],
	[ 'knight-blocks/product' ],
	[ 'knight-blocks/product' ],
];

const ALLOWED_BLOCKS = [
	'knight-blocks/product',
];

/**
 * Register products block.
 *
 * @link   https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/products', {
	title: __( 'Products', 'knight-blocks' ),
	icon: 'tag',
	category: 'design',
	keywords: [
		__( 'products' ),
		__( 'store' ),
		__( 'shop' ),
	],

	supports: {
		align: [ 'wide' ],
	},

	attributes: {
		align: {
			type: 'string',
			default: 'wide',
		},
	},

	/**
	 * Block edit
	 *
	 * @param   {Object} props Props.
	 * @returns {Mixed}  JSX Component.
	 */
	edit: () => {
		return <InnerBlocks
			template={ BLOCKS_TEMPLATE }
			allowedBlocks={ ALLOWED_BLOCKS }
		/>;
	},

	/**
	 * Block save
	 *
	 * @param   {Object} props Props.
	 * @returns {Mixed}  JSX Frontend HTML.
	 */
	save: () => {
		return <section>
			<InnerBlocks.Content />
		</section>;
	},
} );
