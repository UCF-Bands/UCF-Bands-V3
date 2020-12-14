/**
 * MediaUpload handler for an inline image
 *
 * Use MediaControl for InspectorControls component.
 *
 * @since 1.0.0
 */

import './editor.css';

import classnames from 'classnames/dedupe';

const { __ } = wp.i18n;
const { Fragment } = wp.element;
const { MediaUpload } = wp.blockEditor;
const { Button } = wp.components;

const ImagePicker = ( {
	isSelected,
	attachmentID,
	src,
	onSelect,
	onClear,
	help,
	smallButtons,
} ) => {
	return (
		<Fragment>
			<MediaUpload
				onSelect={ onSelect }
				type="image"
				value={ attachmentID }
				render={ ( { open } ) => {
					if ( ! isSelected ) {
						return null;
					}

					return (
						<div
							className={ classnames( {
								'kb-image-picker-buttons': true,
								'kb-image-picker-has-image': attachmentID,
							} ) }
						>
							<Button
								isSecondary
								isSmall={ smallButtons }
								onClick={ open }
							>
								{ __( 'Select Image', 'knight-blocks' ) }
							</Button>

							{ attachmentID ? (
								// show removal button
								<Fragment>
									{ '\u00A0\u00A0' }
									<Button
										isDestructive
										isSmall={ smallButtons }
										onClick={ onClear }
									>
										{ __( '×', 'knight-blocks' ) }
									</Button>
								</Fragment>
							) : (
								// check for "help" text
								help && (
									<span
										className="kb-image-picker-help"
										dangerouslySetInnerHTML={ {
											__html: help,
										} }
									/>
								)
							) }
						</div>
					);
				} }
			/>

			{ attachmentID && src && (
				<img
					src={ src }
					alt={ __( 'Media preview thumbnail', 'knight-blocks' ) }
				/>
			) }
		</Fragment>
	);
};

export default ImagePicker;
