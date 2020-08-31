/**
 * Component for selecting a menu and saving it to meta
 *
 * @see     https://rudrastyh.com/gutenberg/get-posts-in-dynamic-select-control.html
 * @since   1.0.0
 * @package Knight_Blocks
 */

const { __ } = wp.i18n;
const { compose, useInstanceId } = wp.compose;
const { withSelect, withDispatch } = wp.data;
const { BaseControl } = wp.components;

import AsyncSelect from 'react-select/async';
import getApiOptions from '../util/get-api-options';

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
			metaValue: select( 'core/editor' ).getEditedPostAttribute( 'meta' )[ props.metaKey ],

			// Get parent post in case it's needed for lock.
			parent: select( 'core/editor' ).getCurrentPost().parent,
		};
	} ),

)( ( {
	setMetaValue,
	metaValue,
	childLock,
	parent,
} ) => {
	const instanceId = useInstanceId( MetaMenuDropdown );
	const id = `inspector-meta-menu-dropdown-${ instanceId }`;

	return <BaseControl
		id={ id }
		label={ __( 'Menu', 'knight-blocks' ) }
	>
		<AsyncSelect
			name="kb-menu-select"
			value={ metaValue }
			placeholder={ __( 'Select or start typing menu name', 'knight-blocks' ) }
			noOptionsMessage={ () => __( 'No options. Start typing menu name.', 'knight-blocks' ) }
			defaultOptions={ true } // true == loadOptions without value
			loadOptions={ ( inputValue, callback ) => getApiOptions(
				'menus',
				inputValue,
				callback,
				'__experimental',
			) }
			onChange={ ( value ) => setMetaValue( value ) }
			isDisabled={ childLock && parent > 0 }
		/>
	</BaseControl>;
} );

export default MetaMenuDropdown;
