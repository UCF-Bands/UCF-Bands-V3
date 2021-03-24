/**
 * Text and form pattern
 *
 * Columns with heading/paragraph/link and Gravity form.
 *
 * @since 1.0.0
 */
import { __ } from '@wordpress/i18n';

const textAndForm = [
	'core/columns',
	{ align: 'wide' },
	[
		[
			'core/column',
			{ width: '40%', kbTopSpacing: 'medium' },
			[
				[
					'core/heading',
					{
						level: 2,
						content: __(
							'Want to Join a Band at UCF?',
							'knight-blocks'
						),
					},
				],
				[
					'core/paragraph',
					{
						content: __(
							'Receive audition materials, an invitation to our world premiers, and information about how to join.',
							'knight-blocks'
						),
					},
				],
			],
		],
		[
			'core/column',
			{},
			[
				[
					'gravityforms/form',
					{
						formId: 3, // fixed to "General Interest"
						title: false,
						description: false,
						formPreview: false,
					},
				],
			],
		],
	],
];

export default textAndForm;
