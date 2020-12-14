/**
 * Dynamic banner menu select dropdown
 *
 * Uses react-select with async to grab menu items from REST API.
 *
 * @since 1.0.0
 */
const { __ } = wp.i18n;
const { useInstanceId } = wp.compose;
const { BaseControl } = wp.components;

import AsyncSelect from 'react-select/async';
import getApiOptions from '../../util/get-api-options';

function useUniqueId() {
	const instanceId = useInstanceId( MenuSelect );
	return `inspector-dynamic-banner-menu-control-${ instanceId }`;
}

const MenuSelect = ( { selectedMenu, setAttributes } ) => {
	const isChild = knightBlocks.topLevelParent > 0;

	return (
		<BaseControl
			id={ useUniqueId() }
			label={ __( 'Menu', 'knight-blocks' ) }
		>
			<AsyncSelect
				name="kb-dynamic-banner-menu-select"
				value={ selectedMenu }
				placeholder={
					isChild
						? __(
								'Inheriting top level parent menu',
								'knight-blocks'
						  )
						: __(
								'Select or start typing menu name',
								'knight-blocks'
						  )
				}
				noOptionsMessage={ () =>
					__( 'No options. Start typing menu name.', 'knight-blocks' )
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
				onChange={ ( value ) =>
					setAttributes( { selectedMenu: value } )
				}
				isDisabled={ isChild }
			/>
		</BaseControl>
	);
};

export default MenuSelect;
