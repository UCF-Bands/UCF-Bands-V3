/**
 * Dynamic banner "addl" content block edit
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */
const { __ } = wp.i18n;
const { InnerBlocks, InspectorControls } = wp.blockEditor;
const { Fragment } = wp.element;
const { PanelBody, ServerSideRender } = wp.components;

import MetaMenuDropdown from '../../util/meta-menu-dropdown';

const BLOCKS_TEMPLATE = [
	// [
	// 	'knight-blocks/cta-card-compact', {}, [
	// 		[
	// 			'core/heading',
	// 			{
	// 				level: 4,
	// 				placeholder: __( 'Marching Knights Enrollment Has Started', 'knight-blocks' ),
	// 			},
	// 		],
	// 		[
	// 			'core/paragraph',
	// 			{
	// 				placeholder: __( 'Paragraph can go here too.', 'knight-blocks' ),
	// 			},
	// 		],
	// 		[ 'core/button' ]
	// 	],
	// ],
	[ 'core/paragraph', { content: __( 'Yo whatup G', 'knight-blocks' ) } ],
];

/*
 * @todo See if we can lock the template. Unfortunately, 'all' locks down the
 *       cover block's inner blocks as well :(
 */
export default function edit( { className, attributes } ) {
	const { menu } = attributes;

	return (
		<Fragment>

			<InspectorControls>
				<PanelBody title={ __( 'Configuration', 'knight-blocks' ) }>
					<MetaMenuDropdown
						metaKey="_dynamic_banner_menu"
					/>
				</PanelBody>
			</InspectorControls>

			<div className={ className }>
				{ /* inherited if child */ }
				<ServerSideRender
					block="knight-blocks/dynamic-banner-menu"
					attributes={ { id: menu } }
				/>

				{ /* never inherited */ }
				<InnerBlocks
					template={ BLOCKS_TEMPLATE }
					templateLock="all"
				/>

				{ /* inherited if child */ }
				<p>{ __( 'Next performance thing here' ) }</p>
			</div>

		</Fragment>
	);
}
