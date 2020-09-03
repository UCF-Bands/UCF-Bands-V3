/**
 * Dynamic banner block edit
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */
const { __ } = wp.i18n;
const { withSelect } = wp.data;
const { InnerBlocks } = wp.blockEditor;

import isEqual from "lodash/isEqual";

const BLOCKS_TEMPLATE = [
	// disabled because the auto attribute-setting messes up update button
	[
		'core/cover', { align: 'full', className: 'is-style-banner' }, [
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
	[ 'knight-blocks/dynamic-banner-addl' ],
];

let coverContent = false;

/*
 * @todo See if we can lock the template. Unfortunately, 'all' locks down the
 *       cover block's inner blocks as well :( The navigation block is able to
 *       edit its navigation link blocks even if it's inside a a template-locked
 *       InnerBlocks!
 */
const edit = withSelect( ( select, { clientId } ) => {
	return {
		innerBlocks: select( 'core/block-editor' ).getBlocks( clientId ),
	};
} )( ( {
	className,
	innerBlocks,
	// attributes,
	setAttributes,
} ) => {
	// if it's the first load, cache what we have
	if ( innerBlocks.length && coverContent === false ) {
		coverContent = innerBlocks[ 0 ].innerBlocks;
	} else if ( innerBlocks.length && ! isEqual( coverContent, innerBlocks[ 0 ].innerBlocks ) ) {
		coverContent = innerBlocks[ 0 ].innerBlocks;

		setAttributes( {
			sharedCover: coverContent,
		} );
	} else {
		console.log( 'Something was changed, but not a cover innerBlock' );
	}

	return (
		<header className={ className }>
			<InnerBlocks
				template={ BLOCKS_TEMPLATE }
				// templateLock="all"
			/>
		</header>
	);
} );

export default edit;

// export default function edit( { className } ) {
// 	return (
// 		<header className={ className }>
// 			<InnerBlocks
// 				template={ BLOCKS_TEMPLATE }
// 				// templateLock="all"
// 			/>
// 		</header>
// 	);
// }
