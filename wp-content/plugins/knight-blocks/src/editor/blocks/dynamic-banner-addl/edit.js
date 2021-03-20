/**
 * Dynamic banner "addl" content block edit
 *
 * @since 1.0.0
 */
import { __ } from '@wordpress/i18n';
import { InnerBlocks } from '@wordpress/block-editor';

const BLOCKS_TEMPLATE = [
	[ 'knight-blocks/dynamic-banner-menu' ],
	[ 'knight-blocks/cta-card-compact' ],

	// this is causing the "update" button to be weird b/c we aren't saving or something?
	[ 'core/paragraph', { content: __( 'Yo whatup G', 'knight-blocks' ) } ],
];

export default function edit( { className } ) {
	return (
		<div className={ className }>
			{ /* never inherited */ }
			<InnerBlocks
				template={ BLOCKS_TEMPLATE }
				// templateLock="all" // causes compact CTA to lock up :(
			/>

			{ /* inherited if child */ }
			<p>{ __( 'Next performance thing here' ) }</p>
		</div>
	);
}
