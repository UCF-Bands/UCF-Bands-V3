/**
 * Product block
 *
 * Intended for "Products" block.
 *
 * @since 1.0.0
 */

import ServerSideRender from '@wordpress/server-side-render';
import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';

import PostSelectWrapper from '../../components/post-select-wrapper';

import './style.css';
import './editor.css';

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

		return (
			<div { ...useBlockProps() }>
				{ selectedPost.value ? (
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
				) }
			</div>
		);
	},

	save: () => null,

	// for PostSelectWrapper
	postType: 'kb_product',
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
