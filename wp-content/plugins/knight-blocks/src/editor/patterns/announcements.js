/**
 * Announcements pattern
 *
 * Columns with heading/paragraph/link and latest posts.
 *
 * @since 1.0.0
 */
import { __ } from '@wordpress/i18n';

const announcements = [
	'core/columns',
	{ align: 'wide' },
	[
		[
			'core/column',
			{ width: '39%', verticalAlignment: 'center' },
			[
				[
					'core/heading',
					{
						level: 2,
						content: __( 'Announcements', 'knight-blocks' ),
					},
				],
				[
					'core/paragraph',
					{
						content: __(
							'See what our ensembles, students, and faculty are up to as UCF Bands and our community continues to grow.',
							'knight-blocks'
						),
					},
				],
				[
					'knight-blocks/icon-link',
					{
						text: __( 'View All (Set this URL!)', 'knight-blocks' ),
						url: '#',
					},
				],
			],
		],
		[
			'core/column',
			{},
			[
				[
					'core/latest-posts',
					{
						postsToShow: 4,
						displayPostContent: true,
						excerptLength: 11,
						displayPostDate: true,
						postLayout: 'grid',
						columns: 2,
					},
				],
			],
		],
	],
];

export default announcements;
