/**
 * Ordered process block
 *
 * @since 1.0.0
 */

import './style.css';
import './editor.css';

import { formatListNumbered as icon } from '@wordpress/icons';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { InnerBlocks } = wp.blockEditor;

const BLOCKS_TEMPLATE = [
	[ 'knight-blocks/ordered-process-step' ],
	[ 'knight-blocks/ordered-process-step' ],
	[ 'knight-blocks/ordered-process-step' ],
];

const ALLOWED_BLOCKS = [ 'knight-blocks/ordered-process-step' ];

/**
 * Register ordered process block.
 *
 * {@link https://wordpress.org/gutenberg/handbook/block-api/}
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/ordered-process', {
	title: __( 'Ordered Process', 'knight-blocks' ),
	icon,
	category: 'text',
	keywords: [ __( 'process' ), __( 'list' ), __( 'onboarding' ) ],

	/**
	 * Block edit
	 *
	 * @return {Object}  JSX Component.
	 */
	edit: () => {
		return (
			<InnerBlocks
				template={ BLOCKS_TEMPLATE }
				allowedBlocks={ ALLOWED_BLOCKS }
			/>
		);
	},

	/**
	 * Block save
	 *
	 * @return {Object}  JSX Frontend HTML.
	 */
	save: () => {
		return (
			<section>
				<InnerBlocks.Content />
			</section>
		);
	},
} );
