/**
 * Icon/arrow link block edit
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

import IconNameControl from '../../components/icon-name-control';

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

const { __ } = wp.i18n;
const { Fragment } = wp.element;
const { RichText, InspectorControls } = wp.blockEditor;
const { PanelBody, RadioControl } = wp.components;

export default function edit( { attributes, setAttributes } ) {
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

			<InspectorControls>
				<PanelBody title={ __( 'Icon', 'knight-blocks' ) }>
					<IconNameControl
						value={ icon }
						onChange={ ( value ) => setAttributes( { icon: value } ) }
					/>

					<RadioControl
						label={ __( 'Position', 'knight-blocks' ) }
						options={ [
							{ label: __( 'Right', 'knight-blocks' ), value: 'right' },
							{ label: __( 'Left', 'knight-blocks' ), value: 'left' },
						] }
						selected={ iconPosition }
						onChange={ ( value ) => setAttributes( { iconPosition: value } ) }
					/>
				</PanelBody>
			</InspectorControls>

		</Fragment>
	);
}