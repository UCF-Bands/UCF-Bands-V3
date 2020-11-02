/**
 * Side-captioned gallery item block edit
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

import MediaControl from '../../components/media-control';

const { __ } = wp.i18n;
const { Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, TextControl, TextareaControl } = wp.components;

export default function edit( {
	attributes,
	setAttributes,
} ) {
	const {
		heading,
		caption,
		thumbID,
		thumbPreview,
		type,
		url,
		youtubeUrl,
	} = attributes;

	const captionPanel = <PanelBody title={ __( 'Caption', 'knight-blocks' ) }>
		<TextControl
			label={ __( 'Heading', 'knight-blocks' ) }
			value={ heading }
			onChange={ ( value ) => setAttributes( { heading: value } ) }
		/>

		<TextareaControl
			label={ __( 'Body', 'knight-blocks' ) }
			value={ caption }
			onChange={ ( value ) => setAttributes( { caption: value } ) }
		/>
	</PanelBody>;

	const mediaPanel = <PanelBody title={ __( 'Media', 'knight-blocks' ) }>
		<MediaControl
			label={ __( 'Thumbnail', 'knight-blocks' ) }
			attachmentID={ thumbID }
			preview={ thumbPreview }
			onSelect={ ( image ) => setAttributes( {
				thumbID: Number( image.id ),
				thumbPreview: image.sizes.medium ?
					image.sizes.medium.url :
					image.sizes.full.url,
			} ) }
			onClear={ () => setAttributes( {
				thumbID: null,
				thumbPreview: '',
			} ) }
		/>
	</PanelBody>;

	return (
		<Fragment>
			<InspectorControls>
				{ captionPanel }
				{ mediaPanel }
			</InspectorControls>

			<FontAwesomeIcon icon={ [ 'far', 'long-arrow-alt-right' ] } />
			<p>Server-side render here bro</p>
		</Fragment>
	);
}
