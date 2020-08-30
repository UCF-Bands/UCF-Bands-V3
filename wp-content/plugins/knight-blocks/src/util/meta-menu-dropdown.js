/**
 * Component for selecting a menu and saving it to meta
 *
 * @see     https://rudrastyh.com/gutenberg/get-posts-in-dynamic-select-control.html
 * @since   1.0.0
 * @package Knight_Blocks
 */

const { apiFetch } = wp;
const { __ } = wp.i18n;
const { compose } = wp.compose;
const { withSelect, withDispatch } = wp.data;
const { SelectControl } = wp.components;

const MetaMenuDropdown = compose(

	/*
	 * withDispatch allows us to save the menu ID into meta.
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
	withSelect( ( select, props ) => {
		apiFetch( {
			path: '/__experimental/menus',
		} ).then( ( menus ) => {
			console.log( 'GOT MENUS!!', menus );

			return {
				// Get menus (added to props).
				menus: menus,

				// Get existing selected post (added to props).
				metaValue: select( 'core/editor' ).getEditedPostAttribute( 'meta' )[ props.metaKey ],
			};
		} ).catch( ( error ) => {
			console.log( 'Menu fetch error:', error ); // eslint-disable-line no-console

			return {
				menus: [],
				metaValue: null,
			};
		} );

		return {
			// Get menus (added to props).
			menus: null,

			// Get existing selected post (added to props).
			metaValue: select( 'core/editor' ).getEditedPostAttribute( 'meta' )[ props.metaKey ],
		};
	} ),

)( ( props ) => {
	const {
		// menus,
		setMetaValue,
		metaValue,
	} = props;

	const options = [];

	apiFetch( {
		path: '/__experimental/menus',
	} ).then( ( menus ) => {
		console.log( 'DONE WITH REQUEST', menus );

		if ( menus ) {
			options.push( { value: 0, label: __( 'Select an Item', 'knight-blocks' ) } );
			menus.forEach( ( menu ) => {
				options.push( { value: menu.id, label: menu.name } );
			} );
		} else {
			options.push( { value: 0, label: __( 'Loading...', 'knight-blocks' ) } );
		}

		return <SelectControl
			label={ __( 'Menu RIT', 'knight-blocks' ) }
			options={ options }
			onChange={ ( value ) => setMetaValue( value ) }
			value={ metaValue }
		/>;
	} ).catch( ( error ) => {
		console.log( 'Menu fetch error:', error ); // eslint-disable-line no-console
	} );

	//
	// JORDAN: TRY TO DO ASYNC REACT SELECT SINCE THIS IS SUCH A PAIN?
	// reusable REST API endpoint helper to this component, which is part of the
	// dynamic header addl block?
	//

	// if ( menus ) {
	// 	options.push( { value: 0, label: __( 'Select an Item', 'knight-blocks' ) } );
	// 	menus.forEach( ( menu ) => {
	// 		options.push( { value: menu.id, label: menu.name } );
	// 	} );
	// } else {
	// }
	options.push( { value: 0, label: __( 'Loading...', 'knight-blocks' ) } );

	return <SelectControl
		label={ __( 'Menu RIT', 'knight-blocks' ) }
		options={ options }
		onChange={ ( value ) => setMetaValue( value ) }
		value={ metaValue }
	/>;
} );

export default MetaMenuDropdown;
