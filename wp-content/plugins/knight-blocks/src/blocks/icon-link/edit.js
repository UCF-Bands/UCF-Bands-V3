/**
 * Icon/arrow link block edit
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */
const { __ } = wp.i18n;
const { Fragment } = wp.element;
const { RichText } = wp.blockEditor;

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

export default function edit( {
	attributes,
	setAttributes,
	isSelected,
} ) {
	const { text, icon, iconPosition } = attributes;

	return (
		<Fragment>
			<RichText
				tagName="span"
				className="icon-link-text"
				value={ text }
				onChange={ ( value ) => setAttributes( { text: value } ) }
				placeholder={ __( 'Ex: View All', 'knight-blocks' ) }
				allowedFormats={ [] }
			/>

			<FontAwesomeIcon icon={ [ 'far', icon ] } className={ `icon-position-${ iconPosition }` } />

			{ isSelected &&
				<div className="icon-link-icon-edit">
					{ __( 'Icon:', 'knight-blocks' ) }{ ' ' }
					<RichText
						tagName="span"
						value={ icon }
						onChange={ ( value ) => setAttributes( { icon: value } ) }
						placeholder={ __( 'long-arrow-alt-right', 'knight-blocks' ) }
						keepPlaceholderOnFocus
						allowedFormats={ [] }
					/>
				</div>
			}

		</Fragment>
	);
}
