/**
 * Compact CTA card block edit
 *
 * @since 1.0.0
 */

import classnames from 'classnames';

import { __ } from '@wordpress/i18n';
import { RichText, InnerBlocks } from '@wordpress/block-editor';

const ALLOWED_BLOCKS = [ 'core/buttons' ];

const BLOCKS_TEMPLATE = [
	[
		'core/buttons',
		{},
		[
			[
				'core/button',
				{
					text: __( 'Join Rank', 'knight-blocks' ),
					kbSize: 'large',
				},
			],
		],
	],
];

export default function edit( { className, attributes, setAttributes } ) {
	const { heading, paragraph } = attributes;

	return (
		<figure className={ classnames( className, 'kb-card' ) }>
			<div className="cta-card-compact-text-wrap">
				<RichText
					tagName="h4"
					className="cta-card-heading"
					value={ heading }
					onChange={ ( value ) =>
						setAttributes( { heading: value } )
					}
					placeholder={ __(
						'Marching Knights Enrollment Has Started',
						'knight-blocks'
					) }
					allowedFormats={ [] }
				/>
				<RichText
					tagName="p"
					value={ paragraph }
					onChange={ ( value ) =>
						setAttributes( { paragraph: value } )
					}
					placeholder={ __(
						'Paragraph can go here too',
						'knight-blocsk'
					) }
					allowedFormats={ [ 'core/bold', 'core/italic' ] }
				/>
			</div>

			<InnerBlocks
				template={ BLOCKS_TEMPLATE }
				allowedBlocks={ ALLOWED_BLOCKS }
			/>
		</figure>
	);
}
