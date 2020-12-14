/**
 * Add paragraph features
 *
 * @since 1.0.0
 */

import './style.css';
import './editor.css';

const { __ } = wp.i18n;
const { registerBlockStyle } = wp.blocks;

// Register block styles
registerBlockStyle( 'core/paragraph', [
	{
		name: 'featured',
		label: __( 'Featured', 'knight-blocks' ),
		isDefault: false,
	},
] );
