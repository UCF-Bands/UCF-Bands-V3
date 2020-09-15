/**
 * Compact CTA card block edit
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

import classnames from 'classnames';

const { __ } = wp.i18n;
const { RichText, InnerBlocks } = wp.blockEditor;

const ALLOWED_BLOCKS = [
	'core/button',
];

const BLOCKS_TEMPLATE = [
	[ 'core/button', { kbSize: 'large' } ],
];

export default function edit( { className, attributes, setAttributes } ) {
	const {
		heading,
		paragraph,
	} = attributes;

	return (
		<figure className={ classnames( className, 'kb-card' ) }>

			<div className="cta-card-compact-text-wrap">
				<RichText
					tagName="h4"
					className="cta-card-heading"
					value={ heading }
					onChange={ ( value ) => setAttributes( { heading: value } ) }
					placeholder={ __( 'Marching Knights Enrollment Has Started', 'knight-blocks' ) }
					allowedFormats={ [] }
				/>
				<RichText
					tagName="p"
					value={ paragraph }
					onChange={ ( value ) => setAttributes( { paragraph: value } ) }
					placeholder={ __( 'Paragraph can go here too', 'knight-blocsk' ) }
					allowedFormats={ [ 'core/bold', 'core/italic' ] }
				/>
			</div>

			<InnerBlocks
				template={ BLOCKS_TEMPLATE }
				allowedBlocks={ ALLOWED_BLOCKS }
			/>
		</figure>
	);
}
