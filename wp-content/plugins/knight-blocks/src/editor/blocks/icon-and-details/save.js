/**
 * Icon and details block save
 *
 * @since 1.0.0
 */

import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function save( { attributes } ) {
	const { iconID, iconSrc, iconAlt } = attributes;

	return (
		<figure { ...useBlockProps.save() }>
			<div className="icon-and-details-icon">
				{ iconID && (
					<img
						src={ iconSrc }
						alt={ iconAlt }
						data-attachment={ iconID }
					/>
				) }
			</div>

			<figcaption className="icon-and-details-details">
				<InnerBlocks.Content />
			</figcaption>
		</figure>
	);
}
