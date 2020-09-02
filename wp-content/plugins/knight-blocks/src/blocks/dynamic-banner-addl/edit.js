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

import MenuSelect from './menu-select';

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

	// this is causing the "update" button to be weird b/c we aren't saving or something?
	[ 'core/paragraph', { content: __( 'Yo whatup G', 'knight-blocks' ) } ],
];

/*
 * @todo See if we can lock the template. Unfortunately, 'all' locks down the
 *       cover block's inner blocks as well :(
 */
export default function edit( { className, attributes, setAttributes } ) {
	const { selectedMenu } = attributes;

	return (
		<Fragment>

			<InspectorControls>
				<PanelBody title={ __( 'Configuration', 'knight-blocks' ) }>

					<MenuSelect
						selectedMenu={ selectedMenu }
						setAttributes={ setAttributes }
					/>

				</PanelBody>
			</InspectorControls>

			<div className={ className }>
				{ /* inherited if child */ }
				<ServerSideRender
					block="knight-blocks/dynamic-banner-menu"
					attributes={ { selectedMenu: selectedMenu } }
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
