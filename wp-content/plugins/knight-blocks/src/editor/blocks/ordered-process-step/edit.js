/**
 * Ordered process step block edit
 *
 * @since 1.0.0
 */

// import MediaControl from '../../components/media-control';

import { __ } from '@wordpress/i18n';
import { Fragment } from '@wordpress/element';
import {
	useBlockProps,
	InspectorControls,
	URLInput,
} from '@wordpress/block-editor';
import {
	PanelBody,
	TextControl,
	TextareaControl,
	RadioControl,
} from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

export default function edit( { attributes, setAttributes } ) {
	const { status, title, description, type, url } = attributes;

	const detailsPanel = (
		<PanelBody title={ __( 'Details', 'knight-blocks' ) }>
			<RadioControl
				label={ __( 'Status', 'knight-blocks' ) }
				options={ [
					{
						label: __( 'Pending', 'knight-blocks' ),
						value: 'pending',
					},
					{
						label: __( 'Active', 'knight-blocks' ),
						value: 'active',
					},
					{
						label: __( 'Inactive', 'knight-blocks' ),
						value: 'inactive',
					},
				] }
				selected={ status }
				onChange={ ( value ) => setAttributes( { status: value } ) }
				help={ __(
					'Controls indicator color and whether or not the link/download + its icon are displayed.',
					'knight-blocks'
				) }
			/>

			<TextControl
				label={ __( 'Heading', 'knight-blocks' ) }
				value={ title }
				onChange={ ( value ) => setAttributes( { title: value } ) }
			/>

			<TextareaControl
				label={ __( 'Description', 'knight-blocks' ) }
				value={ description }
				onChange={ ( value ) =>
					setAttributes( { description: value } )
				}
				help={ knightBlocks.allowedInlineHTML }
			/>

			<RadioControl
				label={ __( 'Type', 'knight-blocks' ) }
				options={ [
					{
						label: __( 'Static', 'knight-blocks' ),
						value: 'static',
					},
					{
						label: __( 'Link', 'knight-blocks' ),
						value: 'link',
					},
					{
						label: __( 'Download', 'knight-blocks' ),
						value: 'download',
					},
				] }
				selected={ type }
				onChange={ ( value ) => setAttributes( { type: value } ) }
				help={
					type !== 'static' && status !== 'active'
						? __(
								'Link or download will not be available until status is "Active".',
								'knight-blocks'
						  )
						: ''
				}
			/>

			{ type !== 'static' && (
				<URLInput
					label={ __( 'Link or Download URL', 'knight-blocks' ) }
					value={ url }
					onChange={ ( value ) => setAttributes( { url: value } ) }
				/>
			) }
		</PanelBody>
	);

	return (
		<Fragment>
			<InspectorControls>{ detailsPanel }</InspectorControls>

			<div { ...useBlockProps() }>
				<ServerSideRender
					block="knight-blocks/ordered-process-step"
					attributes={ attributes }
				/>
			</div>
		</Fragment>
	);
}
