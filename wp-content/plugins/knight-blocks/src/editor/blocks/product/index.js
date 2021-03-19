/**
 * Product block
 *
 * Intended for "Products" block.
 *
 * @since 1.0.0
 */

import './style.css';
import './editor.css';

import PostSelectWrapper from '../../components/post-select-wrapper';

import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import ServerSideRender from '@wordpress/server-side-render';

const config = {
	title: __( 'Product', 'knight-blocks' ),
	description: __(
		'A highlighted product from the Marching Knights Shopify site',
		'knight-blocks'
	),
	icon: 'tag',
	category: 'design',
	keywords: [ __( 'product' ), __( 'shop' ), __( 'store' ) ],

	edit: ( { attributes } ) => {
		const { selectedPost } = attributes;

		return selectedPost.value ? (
			<ServerSideRender
				block="knight-blocks/product"
				attributes={ attributes }
			/>
		) : (
			<p>
				{ __(
					'Please select a product in block options.',
					'knight-blocks'
				) }
			</p>
		);
	},

	save: () => null,

	// for PostSelectWrapper
	postType: knightBlocks.cpts.product,
	selectLabel: __( 'product', 'knight-blocks' ),
};

/**
 * Register product card
 *
 * {@link https://wordpress.org/gutenberg/handbook/block-api/}
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/product', PostSelectWrapper( config ) );
