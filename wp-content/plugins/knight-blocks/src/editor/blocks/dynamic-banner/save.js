/**
 * Dynamic banner block save
 *
 * @since 1.0.0
 */

import classnames from 'classnames/dedupe';

const { InnerBlocks } = wp.blockEditor;

export default function save( { className, attributes } ) {
	return (
		// eslint-disable-next-line prettier/prettier
		<header className={ classnames(
				className,
				'has-background',
				'no-bg-offset',
				{ 'has-compact-cta': attributes.hasCompactCTA }
			) }
		>
			<InnerBlocks.Content />
		</header>
	);
}
