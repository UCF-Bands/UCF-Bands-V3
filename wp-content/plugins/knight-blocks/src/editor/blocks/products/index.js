/**
 * Products wrapper block
 *
 * @since 1.0.0
 */

import './style.css';
import './editor.css';

import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

const BLOCKS_TEMPLATE = [
	[ 'knight-blocks/product' ],
	[ 'knight-blocks/product' ],
	[ 'knight-blocks/product' ],
	[ 'knight-blocks/product' ],
];

const ALLOWED_BLOCKS = [ 'knight-blocks/product' ];

/**
 * Register products block.
 *
 * {@link https://wordpress.org/gutenberg/handbook/block-api/}
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/products', {
	title: __( 'Products', 'knight-blocks' ),
	icon: 'tag',
	category: 'design',
	keywords: [ __( 'products' ), __( 'store' ), __( 'shop' ) ],

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
	 * @return {Object}  JSX Component.
	 */
	edit: () => {
		return (
			<div { ...useBlockProps() }>
				<InnerBlocks
					template={ BLOCKS_TEMPLATE }
					allowedBlocks={ ALLOWED_BLOCKS }
				/>
			</div>
		);
	},

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
