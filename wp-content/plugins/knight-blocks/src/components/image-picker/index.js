/**
 * MediaUpload handler for an inline image
 *
 * Use MediaControl for InspectorControls component.
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

const { __ } = wp.i18n;
const { Fragment } = wp.element;
const { MediaUpload } = wp.blockEditor;
const { Button } = wp.components;

const ImagePicker = ( {
	attachmentID,
	src,
	onSelect,
	onClear,
} ) => {
	return <Fragment>

		<MediaUpload
			onSelect={ onSelect }
			type="image"
			value={ attachmentID }
			render={ ( { open } ) => {
				return <div className="kb-image-picker-buttons">

					<Button isSecondary onClick={ open }>
						{ __( 'Select Image', 'knight-blocks' ) }
					</Button>

					{ attachmentID && <Fragment>
						{ '\u00A0\u00A0' }
						<Button isDestructive onClick={ onClear }>
							{ __( '×', 'knight-blocks' ) }
						</Button>
					</Fragment> }

				</div>;
			} }
		/>

		{ attachmentID && src &&
			<img src={ src } alt={ __( 'Media preview thumbnail', 'knight-blocks' ) } />
		}
	</Fragment>;
};

export default ImagePicker;
