/**
 * Add group features
 *
 * @since   1.0.0
 * @package knight-blocks
 */

import './style.css';
import './editor.css';

const { __ } = wp.i18n;
const { registerBlockStyle } = wp.blocks;

// Register block styles
registerBlockStyle( 'core/group', [
	{
		name: 'pegasus-background',
		label: __( 'Pegasus Background', 'knight-blocks' ),
		isDefault: false,
	},
] );
