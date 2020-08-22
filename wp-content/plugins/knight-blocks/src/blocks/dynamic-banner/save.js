const { InnerBlocks } = wp.blockEditor;

export default function save( { className } ) {
	return (
		<header className={ className }>
			<InnerBlocks.Content />
		</header>
	);
}
