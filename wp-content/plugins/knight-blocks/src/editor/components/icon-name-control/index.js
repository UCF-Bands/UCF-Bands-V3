/**
 * Font Awsesome icon name control
 *
 * @since 1.0.0
 */

const { __ } = wp.i18n;
const { TextControl } = wp.components;

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
