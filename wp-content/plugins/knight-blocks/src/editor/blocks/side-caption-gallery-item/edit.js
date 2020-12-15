/**
 * Side-captioned gallery item block edit
 *
 * @since 1.0.0
 */

import MediaControl from '../../components/media-control';

const { serverSideRender: ServerSideRender } = wp;
import { __ } from '@wordpress/i18n';
import { Fragment } from '@wordpress/element';
const { InspectorControls, URLInput } = wp.blockEditor;
const { PanelBody, TextControl, TextareaControl, RadioControl } = wp.components;

export default function edit( { attributes, setAttributes } ) {
	const { heading, caption, thumbID, thumbPreview, type, url } = attributes;

	// configure caption controls
	const captionPanel = (
		<PanelBody title={ __( 'Caption', 'knight-blocks' ) }>
			<TextControl
				label={ __( 'Heading', 'knight-blocks' ) }
				value={ heading }
				onChange={ ( value ) => setAttributes( { heading: value } ) }
			/>

			<TextareaControl
				label={ __( 'Body', 'knight-blocks' ) }
				value={ caption }
				onChange={ ( value ) => setAttributes( { caption: value } ) }
				help={ knightBlocks.allowedInlineHTML }
			/>
		</PanelBody>
	);

	// handle some media type conditions
	let urlLabel = false;

	switch ( type ) {
		case 'image-gallery':
			urlLabel = __( 'Gallery URL', 'knight-blocsk' );
			break;

		case 'video':
			urlLabel = __( 'YouTube Embed URL', 'knight-blocks' );
			break;
	}

	// configure media controls
	const mediaPanel = (
		<PanelBody title={ __( 'Media', 'knight-blocks' ) }>
			<RadioControl
				label={ __( 'Type', 'knight-blocks' ) }
				options={ [
					{
						label: __( 'Image', 'knight-blocks' ),
						value: 'image',
					},
					{
						label: __( 'Image Gallery', 'knight-blocks' ),
						value: 'image-gallery',
					},
					{
						label: __( 'Video', 'knight-blocks' ),
						value: 'video',
					},
				] }
				selected={ type }
				onChange={ ( value ) => setAttributes( { type: value } ) }
			/>

			<MediaControl
				label={
					type === 'image'
						? __( 'Image', 'knight-blocks' )
						: __( 'Thumbnail', 'knight-blocks' )
				}
				attachmentID={ thumbID }
				preview={ thumbPreview }
				onSelect={ ( image ) =>
					setAttributes( {
						thumbID: Number( image.id ),
						thumbPreview: image.sizes.medium
							? image.sizes.medium.url
							: image.sizes.full.url,
					} )
				}
				onClear={ () =>
					setAttributes( {
						thumbID: 0,
						thumbPreview: '',
					} )
				}
			/>

			{ urlLabel && (
				<URLInput
					label={ urlLabel }
					value={ url }
					onChange={ ( value ) => setAttributes( { url: value } ) }
				/>
			) }
		</PanelBody>
	);

	return (
		<Fragment>
			<InspectorControls>
				{ captionPanel }
				{ mediaPanel }
			</InspectorControls>

			<ServerSideRender
				block="knight-blocks/side-caption-gallery-item"
				attributes={ attributes }
			/>
		</Fragment>
	);
}
