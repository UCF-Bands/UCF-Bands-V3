/**
 * Dynamic banner block save
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

import classnames from 'classnames/dedupe';

const { InnerBlocks } = wp.blockEditor;

export default function save( { className, attributes } ) {
	return (
		<header className={ classnames(
			className,
			'has-background',
			'no-bg-offset',
			{ 'has-compact-cta': attributes.hasCompactCTA }
		) }>
			<InnerBlocks.Content />
		</header>
	);
}
