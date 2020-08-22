const { InnerBlocks } = wp.blockEditor;

const BLOCKS_TEMPLATE = [
	[ 'core/paragraph' ],
	// [ 'knight-blocks/dynamic-banner-cover' ],
	// [ 'knight-blocks/dynamic-banner-addl' ],
];

export default function edit( {
	className, // grab this stuff out of props?
} ) {
	return (
		<header className={ className }>
			<InnerBlocks
				template={ BLOCKS_TEMPLATE }
				templateLock="all"
			/>
		</header>
	);
}
