/**
 * Icon and details block edit
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

import ImagePicker from '../../components/image-picker';

const { __, sprintf } = wp.i18n;
const { InnerBlocks } = wp.blockEditor;

const ALLOWED_BLOCKS = [
	'core/heading',
	'core/paragraph',
	'core/buttons',
];

const BLOCKS_TEMPLATE = [
	[ 'core/heading', {
		level: 3,
		placeholder: __( 'Ex: Woodwinds & Brass', 'knight-blocks' ),
	} ],
	[ 'core/paragraph', {
		placeholder: __( 'Ex: Auditions will be held in Spring 202X for the fall season. Attending summer clinics is also encouraged.', 'knight-blocks' ),
	} ],
	// do list thing here
	// do icon link here
];

export default function edit( {
	className,
	attributes,
	setAttributes,
	isSelected,
} ) {
	const {
		iconID,
		iconSrc,
	} = attributes;

	return (
		<figure className={ className }>
			<div className="icon-and-details-icon">
				<ImagePicker
					attachmentID={ iconID }
					src={ iconSrc }
					onSelect={ ( image ) => setAttributes( {
						iconID: image.id,
						iconSrc: image.sizes.medium ?
							image.sizes.medium.url :
							image.sizes.full.url,
						iconAlt: image.alt,
					} ) }
					onClear={ () => setAttributes( {
						iconID: '',
						iconSrc: '',
						iconAlt: '',
					} ) }
					help={ sprintf(
						__( 'Icon PNG with %s#ffc90a%s → %s#f4b736%s gradient.', 'knight-blocks' ),
						'<code>', '</code>', '<code>', '</code>'
					) }
					smallButtons
					isSelected={ isSelected }
				/>
			</div>

			<figcaption className="icon-and-details-details">
				<InnerBlocks
					template={ BLOCKS_TEMPLATE }
					allowedBlocks={ ALLOWED_BLOCKS }
				/>
			</figcaption>
		</figure>
	);
}
