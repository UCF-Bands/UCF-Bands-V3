/**
 * Icon link block
 *
 * @since 1.0.0
 */

import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';

import URLWrapper from '../../components/url-wrapper';
import icon from '../../icons/long-arrow-alt-right';

import edit from './edit';
import save from './save';

import './style.css';
import './editor.css';

const config = {
	apiVersion: 2,
	title: __( 'Icon/Arrow Link', 'knight-blocks' ),
	description: __( 'Text button/link with icon or arrow', 'knight-blocks' ),
	icon,
	category: 'design',
	keywords: [
		__( 'icon link', 'knight-blocks' ),
		__( 'arrow link', 'knight-blocks' ),
		__( 'button', 'knight-blocks' ),
	],

	attributes: {
		text: {
			type: 'html',
			source: 'html',
			selector: '.icon-link-text',
			default: __( 'Edit This', 'knight-blocks' ),
		},

		icon: {
			type: 'string',
			source: 'attribute',
			selector: '.far',
			attribute: 'data-icon',
			default: 'long-arrow-alt-right',
		},

		iconPosition: {
			type: 'string',
			default: 'right',
		},
	},

	edit,
	save,
};

/**
 * Register icon/arrow link
 *
 * {@link https://wordpress.org/gutenberg/handbook/block-api/}
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/icon-link', URLWrapper( config ) );
