/**
 * Add group features
 *
 * @since 1.0.0
 */

import { __ } from '@wordpress/i18n';
import { registerBlockStyle, registerBlockVariation } from '@wordpress/blocks';

import './style.css';
import './editor.css';

// Register block styles
registerBlockStyle( 'core/group', [
	{
		name: 'pegasus-background',
		label: __( 'Pegasus Background', 'knight-blocks' ),
		isDefault: false,
	},
] );

// Register block variations
registerBlockVariation( 'core/group', [
	{
		name: 'products',
		title: __( 'Products Section', 'knight-blocks' ),
		attributes: {
			align: 'full',
		},
		innerBlocks: [
			[
				'core/columns',
				{ align: 'wide', verticalAlignment: 'bottom' },
				[
					[
						'core/column',
						{ verticalAlignment: 'bottom' },
						[
							[
								'core/heading',
								{
									content: __(
										'Shop Merchandise',
										'knight-blocks'
									),
								},
							],
							[
								'core/paragraph',
								{
									content: __(
										'Show your support for the Marching Knights with tshirts, jackets, hats, magnets, and more.',
										'knight-blocks'
									),
								},
							],
						],
					],
					[
						'core/column',
						{ verticalAlignment: 'bottom' },
						[
							[
								'core/buttons',
								{ contentJustification: 'right' },
								[
									[
										'core/button',
										{
											url: 'https://shop.ucfbands.com',
											text: __(
												'Shop MK Items',
												'knight-blocks'
											),
										},
									],
								],
							],
						],
					],
				],
			],
			[ 'knight-blocks/products', { align: 'wide' } ],
		],
	},
] );
