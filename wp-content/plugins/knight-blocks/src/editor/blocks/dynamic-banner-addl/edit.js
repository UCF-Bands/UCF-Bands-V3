/**
 * Dynamic banner "addl" content block edit
 *
 * @since 1.0.0
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

const BLOCKS_TEMPLATE = [
	[ 'knight-blocks/dynamic-banner-menu' ],
	[ 'knight-blocks/cta-card-compact' ],
	[
		'full-score-events/next-event',
		{ heading: __( 'Next Performance', 'knight-blocks' ) },
	],
];

export default function Edit() {
	return (
		<div { ...useBlockProps() }>
			{ /* never inherited */ }
			<InnerBlocks
				template={ BLOCKS_TEMPLATE }
				// templateLock="all" // causes compact CTA to lock up :(
			/>

			{ /* inherited if child */ }
			{ /* <p>{ __( 'Next performance thing here' ) }</p> */ }
		</div>
	);
}
