/**
 * Component for selecting a post and saving it to meta
 *
 * WE WERE GOING TO USE THIS FOR THE DYNAMIC BANNER BLOCK'S MENU, BUT MENUS
 * AREN'T EVEN A SELECTABLE POST TYPE :( We'll try Gutenberg plugin for the
 * "Navigation" block for now.
 *
 * @since 1.0.0
 * @see   https://rudrastyh.com/gutenberg/get-posts-in-dynamic-select-control.html
 */

import { __ } from '@wordpress/i18n';
import { compose } from '@wordpress/compose';
import { withSelect, withDispatch } from '@wordpress/data';
import { SelectControl } from '@wordpress/components';

const MetaPostDropdown = compose(
	/*
	 * withDispatch allows us to save the post ID into meta.
	 */
	withDispatch( ( dispatch, props ) => ( {
		// setMetaValue will be added to props and execute the meta update.
		setMetaValue: ( metaValue ) => {
			dispatch( 'core/editor' ).editPost( {
				meta: { [ props.metaKey ]: metaValue },
			} );
		},
	} ) ),

	/*
	 * withSelect allows us to get posts for the SelectControl and get the
	 * existing post meta value
	 */
	withSelect( ( select, props ) => ( {
		// Get post options (added to props).
		posts: select( 'core' ).getEntityRecords( 'postType', props.postType ),

		// Get existing selected post (added to props).
		metaValue: select( 'core/editor' ).getEditedPostAttribute( 'meta' )[
			props.metaKey
		],
	} ) )
)( ( props ) => {
	const { posts, setMetaValue, metaValue, label } = props;

	const options = [];

	if ( posts ) {
		options.push( {
			value: 0,
			label: __( 'Select an Item', 'knight-blocks' ),
		} );
		posts.forEach( ( post ) => {
			options.push( {
				value: post.id,
				label: post.title.rendered,
			} );
		} );
	} else {
		options.push( {
			value: 0,
			label: __( 'Loading…', 'knight-blocks' ),
		} );
	}

	return (
		<SelectControl
			label={ label }
			options={ options }
			onChange={ ( value ) => setMetaValue( value ) }
			value={ metaValue }
		/>
	);
} );

export default MetaPostDropdown;
