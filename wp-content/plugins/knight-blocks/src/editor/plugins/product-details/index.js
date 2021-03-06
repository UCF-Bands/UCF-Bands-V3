/**
 * Product detail sidebar plugin
 *
 * @since 1.0.0
 */

import { __ } from '@wordpress/i18n';
import { compose } from '@wordpress/compose';
import { withSelect, withDispatch } from '@wordpress/data';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { URLInput } from '@wordpress/block-editor';
import { TextControl } from '@wordpress/components';
import { registerPlugin } from '@wordpress/plugins';

const render = compose(
	/*
	 * withDispatch allows us to save meta values
	 */
	withDispatch( ( dispatch ) => ( {
		setPrice: ( value ) => {
			dispatch( 'core/editor' ).editPost( {
				meta: { _price: Number( value ) },
			} );
		},

		setShopUrl: ( value ) => {
			dispatch( 'core/editor' ).editPost( {
				meta: { _shop_url: value },
			} );
		},
	} ) ),

	/*
	 * withSelect allows us to get existing meta values
	 */
	withSelect( ( select ) => {
		const meta = Object.assign(
			{},
			select( 'core/editor' ).getEditedPostAttribute( 'meta' )
		);

		return {
			postType: select( 'core/editor' ).getCurrentPostType(),
			price: meta._price,
			shopUrl: meta._shop_url,
		};
	} )
)( ( props ) => {
	// sanity check for product
	if ( props.postType !== 'kb_product' ) {
		return null;
	}

	const { price, shopUrl, setPrice, setShopUrl } = props;

	return (
		<PluginDocumentSettingPanel
			className="kb-product-details"
			title={ __( 'Product Details', 'knight-blocks' ) }
		>
			<URLInput
				label={ __( 'Shop URL', 'knight-blocks' ) }
				value={ shopUrl }
				onChange={ setShopUrl }
			/>

			<TextControl
				label={ __( 'Price ($)', 'knight-blocks' ) }
				type="number"
				min={ 0 }
				step={ 0.01 }
				value={ price }
				onChange={ setPrice }
			/>
		</PluginDocumentSettingPanel>
	);
} );

// register the sidebar plugin
registerPlugin( 'kb-product-details', { render, icon: 'tag' } );
