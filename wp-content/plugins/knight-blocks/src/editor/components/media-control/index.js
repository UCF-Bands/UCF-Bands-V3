/**
 * Media InspectorControls handler
 *
 * @since 1.0.0
 */

import { __ } from '@wordpress/i18n';
import { Fragment } from '@wordpress/element';
import { MediaUpload } from '@wordpress/block-editor';
import { BaseControl, Button } from '@wordpress/components';

const MediaControl = ( {
	label,
	attachmentID,
	preview,
	onSelect,
	onClear,
} ) => {
	return (
		// eslint-disable-next-line @wordpress/no-base-control-with-label-without-id
		<BaseControl label={ label }>
			<MediaUpload
				onSelect={ onSelect }
				type="image"
				value={ attachmentID }
				render={ ( { open } ) => {
					return (
						<div className="components-base-control__field">
							<Button isSecondary onClick={ open }>
								{ __( 'Select Image', 'knight-blocks' ) }
							</Button>

							{ attachmentID > 0 && (
								<Fragment>
									{ '\u00A0\u00A0' }
									<Button
										isDestructive
										isSecondary
										onClick={ onClear }
									>
										{ __( 'Remove', 'knight-blocks' ) }
									</Button>
								</Fragment>
							) }
						</div>
					);
				} }
			/>

			{ attachmentID > 0 && preview && (
				<img
					src={ preview }
					alt={ __( 'Media preview thumbnail', 'knight-blocks' ) }
				/>
			) }
		</BaseControl>
	);
};

export default MediaControl;
