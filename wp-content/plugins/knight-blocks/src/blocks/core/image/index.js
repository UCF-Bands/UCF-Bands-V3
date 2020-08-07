/**
 * Add image features
 *
 * @since   1.0.0
 * @package knight-blocks
 */

import './style.scss';
import './editor.scss';

const { __ } = wp.i18n;
const { registerBlockStyle } = wp.blocks;

// Register block styles
registerBlockStyle( 'core/image', [
	{
		name: 'boxed',
		label: __( 'Boxed Shadow', 'knight-blocks' ),
		isDefault: false,
	},
] );
