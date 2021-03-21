/**
 * Add image features
 *
 * @since 1.0.0
 */

import { __ } from '@wordpress/i18n';
import { registerBlockStyle } from '@wordpress/blocks';

import './style.css';
import './editor.css';

// Register block styles
registerBlockStyle( 'core/image', [
	{
		name: 'boxed',
		label: __( 'Boxed Shadow', 'knight-blocks' ),
		isDefault: false,
	},
] );
