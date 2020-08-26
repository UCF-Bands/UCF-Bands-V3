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
				</PanelBody>
			</InspectorControls>

			<div className={ className }>
				<ServerSideRender
					block="knight-blocks/dynamic-banner-menu"
					attributes={ { id: menu } }
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
