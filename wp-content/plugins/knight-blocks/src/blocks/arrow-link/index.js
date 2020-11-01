/**
 * Arrow link block
 *
 * @todo    Kill this--it's just an example for importing an icon
 * @since   1.0.0
 * @package Knight_Blocks
 */

import './style.scss';
import './editor.scss';

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';

import URLWrapper from '../../components/url-wrapper';

import edit from './edit';
import save from './save';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

const config = {
	title: __( 'Arrow Link', 'knight-blocks' ),
	description: __( 'Text button/link with arrow', 'knight-blocks' ),
	icon: <FontAwesomeIcon icon={ [ 'far', 'long-arrow-right' ] } />,
	category: 'design',
	keywords: [
		__( 'Arrow Link', 'knight-blocks' ),
		__( 'Button', 'knight-blocks' ),
	],

	attributes: {
		text: {
			type: 'html',
			source: 'html',
			selector: '.arrow-link-text',
			default: __( 'Edit This', 'knight-blocks' ),
		},
	},

	edit,
	save,
};

/**
 * Register arrow link
 *
 * @link   https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/arrow-link', URLWrapper( config ) );
