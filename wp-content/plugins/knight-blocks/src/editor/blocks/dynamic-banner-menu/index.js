/**
 * Dynamic banner's menu
 *
 * This is intended to be a server-side-rendered block that pulls the parent
 * post's dynamic banner menu.
 *
 * @since 1.0.0
 */

import './style.css';
import './editor.css';

import MenuSelect from './menu-select';

const { serverSideRender: ServerSideRender } = wp;
import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls } from '@wordpress/block-editor';
import { Fragment } from '@wordpress/element';
import { PanelBody } from '@wordpress/components';
import { cover as icon } from '@wordpress/icons';

/**
 * Register dynamic banner menu
 *
 * {@link https://wordpress.org/gutenberg/handbook/block-api/}
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/dynamic-banner-menu', {
	title: __( 'Dynamic Banner Menu', 'knight-blocks' ),
	description: __(
		"Menu inherited from the current page/post parent's Dynamic Banner Menu block",
		'knight-blocks'
	),
	icon,
	category: 'design',
	keywords: [ __( 'banner' ), __( 'section menu' ) ],

	parent: [ 'knight-blocks/dynamic-banner-addl' ],

	attributes: {
		selectedMenu: {
			type: 'object',
			default: {
				label: '',
				value: '',
			},
			source: 'meta',
			meta: '_dynamic_banner_menu',
		},
	},

	edit: ( { attributes, setAttributes } ) => {
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

				<ServerSideRender
					block="knight-blocks/dynamic-banner-menu"
					attributes={ attributes }
				/>
			</Fragment>
		);
	},

	save: () => null,
} );
