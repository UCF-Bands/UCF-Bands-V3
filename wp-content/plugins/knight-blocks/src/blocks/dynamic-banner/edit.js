/**
 * Dynamic banner block edit
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */
const { __ } = wp.i18n;
const { getBlockContent } = wp.blocks;
const { withSelect } = wp.data;
const { InnerBlocks } = wp.blockEditor;

import isEqual from 'lodash/isEqual';
import classnames from 'classnames/dedupe';

const BLOCKS_TEMPLATE = [];

BLOCKS_TEMPLATE.push( knightBlocks.topLevelParent > 0 ?
	// if we have a top level parent, we want to inherit its cover content
	[ 'knight-blocks/dynamic-banner-shared-cover' ] :

	// otherwise, we'll do the editable InnerBlocks with this cover template
	// @todo the two classnames are being duplicated in the saved HTML?
	[
		'core/cover', { align: 'full', className: 'is-style-banner is-dynamic-banner-cover' }, [
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
					placeholder: __( 'Directors: Schreier and Kizer', 'knight-blocks' ),
				},
			],
		],
	],
);

// always do additional stuff
BLOCKS_TEMPLATE.push( [ 'knight-blocks/dynamic-banner-addl' ] );

let
	coverContent = false,
	coverAttribues = false,
	hasCompactCTA = null;

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
	attributes,
	setAttributes,
} ) => {
	// if it's the first load, cache what we have
	if ( innerBlocks.length && coverContent === false ) {
		coverContent = innerBlocks[ 0 ].innerBlocks;
		coverAttribues = innerBlocks[ 0 ].attributes;

	// otherwise, see if the cover was changed during an edit of this block, and
	// re-save it to the inherited meta if so
	} else if (
		innerBlocks.length &&
		(
			! isEqual( coverContent, innerBlocks[ 0 ].innerBlocks ) ||
			! isEqual( coverAttribues, innerBlocks[ 0 ].attributes )
		)
	) {
		coverContent = innerBlocks[ 0 ].innerBlocks;
		coverAttribues = innerBlocks[ 0 ].attributes;

		setAttributes( {
			sharedCover: coverContent,
			sharedCoverHTML: getBlockContent( innerBlocks[ 0 ] ),
		} );
	}

	// if it's the first load, cache whether or not we have a nested compact CTA
	if ( hasCompactCTA === null ) {
		hasCompactCTA = attributes.hasCompactCTA;

	// check if compact CTA has been added or removed
	} else if (
		hasCompactCTA !== (
			innerBlocks.length > 1 &&
			typeof innerBlocks[ 1 ].innerBlocks === 'object' &&
			_.filter( innerBlocks[ 1 ].innerBlocks, { name: 'knight-blocks/cta-card-compact' } ).length > 0
		)
	) {
		hasCompactCTA = ! hasCompactCTA;
		setAttributes( {
			hasCompactCTA: hasCompactCTA,
		} );
	}

	return (
		<header className={ classnames(
			className,
			'has-background',
			'no-bg-offset',
			{ 'has-compact-cta': attributes.hasCompactCTA }
		) }>
			<InnerBlocks
				template={ BLOCKS_TEMPLATE }
				// templateLock="all"
			/>
		</header>
	);
} );

export default edit;
