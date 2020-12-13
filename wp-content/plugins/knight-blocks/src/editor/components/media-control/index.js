/**
 * Media InspectorControls handler
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

const { __ } = wp.i18n;
const { Fragment } = wp.element;
const { MediaUpload } = wp.blockEditor;
const { BaseControl, Button } = wp.components;

const MediaControl = ( {
	label,
	attachmentID,
	preview,
	onSelect,
	onClear,
} ) => {
	return <BaseControl label={ label }>
		<MediaUpload
			onSelect={ onSelect }
			type="image"
			value={ attachmentID }
			render={ ( { open } ) => {
				return <div className="components-base-control__field">

					<Button isSecondary onClick={ open }>
						{ __( 'Select Image', 'knight-blocks' ) }
					</Button>

					{ attachmentID > 0 && <Fragment>
						{ '\u00A0\u00A0' }
						<Button isDestructive isSecondary onClick={ onClear }>
							{ __( 'Remove', 'knight-blocks' ) }
						</Button>
					</Fragment> }

				</div>;
			} }
		/>

		{ attachmentID > 0 && preview &&
			<img src={ preview } alt={ __( 'Media preview thumbnail', 'knight-blocks' ) } />
		}
	</BaseControl>;
};

export default MediaControl;
