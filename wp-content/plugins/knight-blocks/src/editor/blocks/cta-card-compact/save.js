/**
 * Compact CTA card block save
 *
 * @since 1.0.0
 */

import classnames from 'classnames';

import { RichText, InnerBlocks } from '@wordpress/block-editor';

export default function save( { className, attributes } ) {
	const { heading, paragraph } = attributes;

	return (
		<figure className={ classnames( className, 'kb-card' ) }>
			<div className="cta-card-compact-text-wrap">
				<RichText.Content
					tagName="h4"
					className="cta-card-heading"
					value={ heading }
				/>
				{ paragraph && (
					<RichText.Content tagName="p" value={ paragraph } />
				) }
			</div>

			<InnerBlocks.Content />
		</figure>
	);
}
