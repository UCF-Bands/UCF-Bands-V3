/**
 * Compact CTA card block save
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

import classnames from 'classnames';

const { InnerBlocks } = wp.blockEditor;

export default function save( { className } ) {
	return (
		<figure className={ classnames( className, 'ucf-card' ) }>
			<InnerBlocks.Content />
		</figure>
	);
}
