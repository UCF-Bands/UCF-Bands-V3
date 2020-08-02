/**
 * Add cover features
 *
 * @since   1.0.0
 * @package knight-blocks
 */

// import './style.scss';
// import './editor.scss';

const { __ } = wp.i18n;
const { registerBlockStyle } = wp.blocks;

// Register block styles
registerBlockStyle( 'core/cover', [
	{
		name: 'banner',
		label: __( 'Banner', 'knight-blocks' ),
		isDefault: false,
	},
] );
