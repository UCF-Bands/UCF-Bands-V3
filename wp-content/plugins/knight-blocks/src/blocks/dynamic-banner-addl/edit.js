/**
 * Dynamic banner "addl" content block edit
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */
const { __ } = wp.i18n;
const { InnerBlocks, InspectorControls } = wp.blockEditor;
const { Fragment } = wp.element;
const { ServerSideRender, PanelBody } = wp.components; // Yells about wp.serverSideRender but doesn't work?

import MetaPostDropdown from '../../util/meta-post-dropdown';

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
	return (
		<Fragment>

			<InspectorControls>
				<PanelBody title={ __( 'Configuration', 'knight-blocks' ) }>
					<MetaPostDropdown
						label={ __( 'Whatup jim', 'knight-blocks' ) }
						postType="nav_menu_item"
						metaKey="_dynamic_banner_menu"
					/>
				</PanelBody>
			</InspectorControls>

			<div className={ className }>
				<ServerSideRender
					block="knight-blocks/dynamic-banner-menu"
					attributes={ attributes }
				/>

				<InnerBlocks
					template={ BLOCKS_TEMPLATE }
					templateLock="all"
				/>

				<p>{ __( 'Next performance thing here' ) }</p>
			</div>

		</Fragment>
	);
}
