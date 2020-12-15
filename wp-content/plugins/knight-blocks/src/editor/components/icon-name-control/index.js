/**
 * Font Awsesome icon name control
 *
 * @since 1.0.0
 */

import { __ } from '@wordpress/i18n';
import { TextControl } from '@wordpress/components';

const IconNameControl = ( { value, onChange } ) => {
	const viewIcons = (
		<a
			href="https://fontawesome.com/icons?d=gallery&s=regular"
			target="_blank"
			rel="noopener noreferrer"
		>
			{ __( 'View Icons', 'knight-blocks' ) }
		</a>
	);

	return (
		<TextControl
			label={ __( 'Font Awesome Icon Name', 'knight-blocks' ) }
			placeholder={ __( 'Ex: rocket', 'knight-blocks' ) }
			help={ viewIcons }
			onChange={ onChange }
			value={ value }
		/>
	);
};

export default IconNameControl;
