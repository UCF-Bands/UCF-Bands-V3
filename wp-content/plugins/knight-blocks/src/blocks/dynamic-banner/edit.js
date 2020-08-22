/**
 * Dynamic banner block edit
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */
const { __ } = wp.i18n;
const { InnerBlocks } = wp.blockEditor;

const BLOCKS_TEMPLATE = [
	[
		'core/cover', { align: 'full' }, [
			[
				'core/heading',
				{
					level: 1,
					placeholder: __( 'Marching Knights', 'knight-blocks' ),
				},
			],
			[
				'core/paragraph',
				{
					className: 'is-style-featured',
					placeholder: __( 'Directors: Schreier and Kizer', 'knight-blocks' )
				},
			],
		],
	],
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
