/**
 * Dynamic banner block save
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */
const { InnerBlocks } = wp.blockEditor;

export default function save( { className } ) {
	return (
		<header className={ className }>
			<InnerBlocks.Content />
		</header>
	);
}
