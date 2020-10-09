/**
 * Pegasus background block
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

// import './style.scss';
// import './editor.scss';

import icon from '../../icons/pegasus';

const { serverSideRender: ServerSideRender } = wp;
const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

/**
 * Register pegasus background
 *
 * @link   https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/pegasus-background', {
	title: __( 'Pegasus Background', 'knight-blocks' ),
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