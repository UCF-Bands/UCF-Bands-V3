/**
 * Dynamic banner block save
 *
 * @since 1.0.0
 */

import classnames from 'classnames/dedupe';

import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function save( { attributes } ) {
	const blockProps = useBlockProps.save( {
		className: classnames( {
			'has-background': true,
			'no-bg-offset': true,
			'has-compact-cta': attributes.hasCompactCTA,
		} ),
	} );

	return (
		<header { ...blockProps }>
			<InnerBlocks.Content />
		</header>
	);
}
