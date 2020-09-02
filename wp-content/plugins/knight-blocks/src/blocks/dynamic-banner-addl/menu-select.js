/**
 * Dynamic banner menu select dropdown
 *
 * Uses react-select with async to grab menu items from REST API.
 *
 * @since   1.0.0
 * @package Knight_Blocks
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

const MenuSelect = ( {
	selectedMenu,
	setAttributes,
} ) => {
	return <BaseControl
		id={ useUniqueId() }
		label={ __( 'Menu', 'knight-blocks' ) }
	>
		<AsyncSelect
			name="kb-dynamic-banner-menu-select"
			value={ selectedMenu }
			placeholder={ __( 'Select or start typing menu name' ) }
			noOptionsMessage={ () => __( 'No options. Start typing menu name.', 'knight-blocks' ) }
			defaultOptions={ true } // true == loadOptions without value
			loadOptions={ ( inputValue, callback ) => getApiOptions(
				'menus',
				inputValue,
				callback,
				'__experimental',
			) }
			onChange={ ( value ) => setAttributes( { selectedMenu: value } ) }
			// isDisabled={ parent > 0 }
		/>
	</BaseControl>;
};

export default MenuSelect;
