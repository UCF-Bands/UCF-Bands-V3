/**
 * Compact CTA card block save
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

import classnames from 'classnames';

const { RichText, InnerBlocks } = wp.blockEditor;

export default function save( { className, attributes } ) {
	const {
		heading,
		paragraph,
	} = attributes;

	return (
		<figure className={ classnames( className, 'kb-card' ) }>

			<div className="cta-card-compact-text-wrap">
				<RichText.Content
					tagName="h4"
					className="cta-card-heading"
					value={ heading }
				/>
				<RichText.Content
					tagName="p"
					value={ paragraph }
				/>
			</div>

			<InnerBlocks.Content />
		</figure>
	);
}
