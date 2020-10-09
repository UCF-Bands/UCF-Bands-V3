/**
 * Dynamic banner "addl" content block save
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */
const { InnerBlocks } = wp.blockEditor;

export default function save( { className } ) {
	return (
		<div className={ className }>
			<InnerBlocks.Content />
		</div>
	);
}
