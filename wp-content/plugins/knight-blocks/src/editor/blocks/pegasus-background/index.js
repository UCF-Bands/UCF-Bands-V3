/**
 * Pegasus background block
 *
 * @todo    Kill this--it's just an example for importing an icon
 * @since 1.0.0
 */

import './style.css';

import icon from '../../icons/pegasus';

import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { ServerSideRender } from '@wordpress/server-side-render';

/**
 * Register pegasus background
 *
 * {@link  https://wordpress.org/gutenberg/handbook/block-api/}
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/pegasus-background', {
	title: __( '(ICON EXAMPLE ONLY) Pegasus Background', 'knight-blocks' ),
	description: __(
		'Faded + floating Pegasus background for "intro" sections',
		'knight-blocks'
	),
	icon,
	category: 'design',
	keywords: [
		__( 'Pegasus', 'knight-blocks' ),
		__( 'background', 'knight-blocks' ),
	],

	edit: () => <ServerSideRender block="knight-blocks/pegasus-background" />,
	save: () => null,
} );
