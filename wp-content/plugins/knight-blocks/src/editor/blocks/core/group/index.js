/**
 * Add group features
 *
 * @since 1.0.0
 */

import './style.css';
import './editor.css';

import { __ } from '@wordpress/i18n';
import { registerBlockStyle } from '@wordpress/blocks';

// Register block styles
registerBlockStyle( 'core/group', [
	{
		name: 'pegasus-background',
		label: __( 'Pegasus Background', 'knight-blocks' ),
		isDefault: false,
	},
] );
