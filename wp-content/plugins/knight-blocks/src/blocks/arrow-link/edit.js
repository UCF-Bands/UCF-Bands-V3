/**
 * Arrow link block edit
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
} ) {
	const { text } = attributes;

	return (
		<Fragment>
			<RichText
				tagName="span"
				className="arrow-link-text"
				value={ text }
				onChange={ ( value ) => setAttributes( { text: value } ) }
				placeholder={ __( 'Ex: View All', 'knight-blocks' ) }
				allowedFormats={ [] }
			/>
			<FontAwesomeIcon icon={ [ 'far', 'long-arrow-alt-right' ] } />
		</Fragment>
	);
}
