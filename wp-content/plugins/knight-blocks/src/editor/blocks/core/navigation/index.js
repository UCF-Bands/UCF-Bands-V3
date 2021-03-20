/**
 * Add navigation features
 *
 * @since 1.0.0
 */

import { __ } from '@wordpress/i18n';
import { registerBlockStyle } from '@wordpress/blocks';

// Register block styles
registerBlockStyle( 'core/navigation', [
	{
		name: 'banner',
		label: __( 'Banner', 'knight-blocks' ),
		isDefault: false,
	},
] );
