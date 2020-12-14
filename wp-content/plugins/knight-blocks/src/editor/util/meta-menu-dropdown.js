/**
 * Component for selecting a menu and saving it to meta
 *
 * @see   https://rudrastyh.com/gutenberg/get-posts-in-dynamic-select-control.html
 * @since 1.0.0
 *
 * @todo  KILL THIS ZOMBIE?
 */

const { __ } = wp.i18n;
const { parse } = wp.blocks;
const { compose, useInstanceId } = wp.compose;
const { withSelect, withDispatch } = wp.data;
const { BaseControl } = wp.components;

import AsyncSelect from 'react-select/async';
import getApiOptions from '../util/get-api-options';

const getParentPostBannerMenu = ( blocks ) => {
	// we're in the outermost block iterator or inner blocks
	if ( Array.isArray( blocks ) ) {
		for ( const block of blocks ) {
			const selectedMenu = getParentPostBannerMenu( block );

			if ( selectedMenu ) {
				return selectedMenu;
			}
		}
	}

	// we're in an individual block now
	if ( blocks.name === 'knight-blocks/dynamic-banner-addl' ) {
		return blocks.attributes.selectedMenu;
	}

	// now try any inner blocks
	if ( blocks.innerBlocks.length > 0 ) {
		return getParentPostBannerMenu( blocks.innerBlocks );
	}

	return false;
};

const MetaMenuDropdown = compose(
	/*
	 * withDispatch allows us to save the menu ID into meta.
	 */
	withDispatch( ( dispatch, props ) => ( {
		// setMetaValue will be added to props and execute the meta update.
		setMetaValue: ( value ) => {
			dispatch( 'core/editor' ).editPost( {
				meta: { [ props.metaKey ]: value },
			} );
		},
	} ) ),

	/*
	 * withSelect allows us to get posts for the SelectControl and get the
	 * existing post meta value
	 */
	withSelect( ( select, props ) => {
		return {
			// Get existing selected post (added to props).
			metaValue: select( 'core/editor' ).getEditedPostAttribute( 'meta' )[
				props.metaKey
			],

			// Get parent post in case it's needed for lock.
			parent: select( 'core/editor' ).getCurrentPost().parent,

			// THIS DOESN'T WORK WITH TOP LEVEL PARENTS!!!
			// MAYBE TRY "NATIVE" meta ATTRIBUTE for the addl block instead
			// of doing it here?
			parentPost: select( 'core' ).getEntityRecord(
				'postType',
				'page',
				select( 'core/editor' ).getCurrentPost().parent
			),
		};
	} )
)(
	( {
		setMetaValue,
		metaValue,
		childLock,
		parent,

		selectedMenu,
		setAttributes,
		parentPost,
	} ) => {
		const instanceId = useInstanceId( MetaMenuDropdown );
		const id = `inspector-meta-menu-dropdown-${ instanceId }`;

		if ( parentPost ) {
			const parentPostBannerMenu = getParentPostBannerMenu(
				parse( parentPost.content.raw )
			);

			if ( parentPostBannerMenu ) {
				selectedMenu = parentPostBannerMenu;
			}
		}

		return (
			<BaseControl id={ id } label={ __( 'Menu', 'knight-blocks' ) }>
				<AsyncSelect
					name="kb-menu-select"
					// value={ metaValue }
					value={ selectedMenu }
					placeholder={ __(
						'Select or start typing menu name',
						'knight-blocks'
					) }
					noOptionsMessage={ () =>
						__(
							'No options. Start typing menu name.',
							'knight-blocks'
						)
					}
					defaultOptions={ true } // true == loadOptions without value
					loadOptions={ ( inputValue, callback ) =>
						getApiOptions(
							'menus',
							inputValue,
							callback,
							'__experimental'
						)
					}
					// onChange={ ( value ) => setMetaValue( value ) }
					onChange={ ( value ) =>
						setAttributes( { selectedMenu: value } )
					}
					isDisabled={ childLock && parent > 0 }
				/>
			</BaseControl>
		);
	}
);

export default MetaMenuDropdown;
