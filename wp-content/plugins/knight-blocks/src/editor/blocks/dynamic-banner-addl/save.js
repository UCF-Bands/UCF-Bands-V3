/**
 * Dynamic banner "addl" content block save
 *
 * @since 1.0.0
 */
import { InnerBlocks } from '@wordpress/block-editor';

export default function save( { className } ) {
	return (
		<div className={ className }>
			<InnerBlocks.Content />
		</div>
	);
}
