/**
 * Icon link block
 *
 * @since 1.0.0
 */

import './style.css';
import './editor.css';

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

import URLWrapper from '../../components/url-wrapper';

import edit from './edit';
import save from './save';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

const config = {
	title: __( 'Icon/Arrow Link', 'knight-blocks' ),
	description: __( 'Text button/link with icon or arrow', 'knight-blocks' ),
	icon: <FontAwesomeIcon icon={ [ 'far', 'long-arrow-right' ] } />,
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
