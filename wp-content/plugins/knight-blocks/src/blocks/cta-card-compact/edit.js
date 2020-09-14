/**
 * Compact CTA card block edit
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

import classnames from 'classnames';

const { __ } = wp.i18n;
const { InnerBlocks } = wp.blockEditor;

const ALLOWED_BLOCKS = [
	'core/heading',
	'core/paragraph',
	'core/button',
];

const BLOCKS_TEMPLATE = [
	[
		'core/heading',
		{
			level: 4,
			placeholder: __( 'Marching Knights Enrollment Has Started', 'knight-blocks' ),
		},
	],
	[
		'core/paragraph',
		{
			placeholder: __( 'Paragraph can go here too.', 'knight-blocks' ),
		},
	],
	[ 'core/button', { kbSize: 'has-size-large' } ],
];

export default function edit( { className } ) {
	return (
		<figure className={ classnames( className, 'ucf-card' ) }>
			<InnerBlocks
				template={ BLOCKS_TEMPLATE }
				allowedBlocks={ ALLOWED_BLOCKS }
			/>
		</figure>
	);
}
