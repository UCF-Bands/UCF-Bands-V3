/**
 * Dynamic banner "addl" content block save
 *
 * @since 1.0.0
 */
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function save() {
	return (
		<div { ...useBlockProps.save() }>
			<InnerBlocks.Content />
		</div>
	);
}
