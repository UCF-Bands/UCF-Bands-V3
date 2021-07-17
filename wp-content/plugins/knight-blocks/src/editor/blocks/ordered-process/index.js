/**
 * Ordered process block
 *
 * @since 1.0.0
 */

import { __ } from '@wordpress/i18n';
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import { formatListNumbered as icon } from '@wordpress/icons';

import './style.css';
import './editor.css';

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
	apiVersion: 2,
	title: __( 'Ordered Process', 'knight-blocks' ),
	description: __(
		'A detailed list of things to do to complete something. Use wide block width for bigger headings and more spacing.',
		'knight-blocks'
	),
	icon,
	category: 'text',
	keywords: [ __( 'process' ), __( 'list' ), __( 'onboarding' ) ],

	supports: {
		align: [ 'wide' ],
	},

	attributes: {
		align: {
			type: 'string',
		},
	},

	/**
	 * Block edit
	 *
	 * @return {Object}  JSX Component.
	 */
	edit: () => {
		return (
			<div { ...useBlockProps() }>
				<InnerBlocks
					template={ BLOCKS_TEMPLATE }
					allowedBlocks={ ALLOWED_BLOCKS }
				/>
			</div>
		);
	},

	/**
	 * Block save
	 *
	 * @return {Object}  JSX Frontend HTML.
	 */
	save: () => {
		return (
			<section { ...useBlockProps.save() }>
				<InnerBlocks.Content />
			</section>
		);
	},
} );
