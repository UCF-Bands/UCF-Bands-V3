/**
 * Dynamic banner's shared cover (dynamic)
 *
 * This is intended to be a server-side-rendered block that pulls the parent
 * post's dynamic banner > core/cover block.
 *
 * @since 1.0.0
 */

import './editor.css';

import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { cover as icon } from '@wordpress/icons';
import ServerSideRender from '@wordpress/server-side-render';

/**
 * Register dynamic banner shared cover
 *
 * {@link https://wordpress.org/gutenberg/handbook/block-api/}
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/dynamic-banner-shared-cover', {
	apiVersion: 2,
	title: __( 'Dynamic Banner Shared Cover', 'knight-blocks' ),
	description: __(
		"Cover inherited from the current page/post parent's Dynamic Cover block",
		'knight-blocks'
	),
	icon,
	category: 'design',
	keywords: [ __( 'banner' ), __( 'cover' ), __( 'section header' ) ],

	parent: [ 'knight-blocks/dynamic-banner' ],

	edit: () => (
		<ServerSideRender block="knight-blocks/dynamic-banner-shared-cover" />
	),
	save: () => null,
} );
