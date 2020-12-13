/**
 * Add navigation features
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

const { __ } = wp.i18n;
const { registerBlockStyle } = wp.blocks;

// Register block styles
registerBlockStyle( 'core/navigation', [
	{
		name: 'banner',
		label: __( 'Banner', 'knight-blocks' ),
		isDefault: false,
	},
] );
