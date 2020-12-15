/**
 * "Details" block
 *
 * Basically just some text with a border on the left. Couldn't think of a
 * better name.
 *
 * @since 1.0.0
 */

import './style.css';
import './editor.css';

import { alignLeft as icon } from '@wordpress/icons';

import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { RichText } from '@wordpress/block-editor';

/**
 * Register details block
 *
 * {@link https://wordpress.org/gutenberg/handbook/block-api/}
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/details', {
	title: __( 'Details', 'knight-blocks' ),
	description: __(
		'Text block with a left border intended for details',
		'knight-blocks'
	),
	icon,
	category: 'design',
	keywords: [ __( 'details' ), __( 'information' ), __( 'border' ) ],

	attributes: {
		content: {
			type: 'string',
			placeholder: `<strong>${ __(
				'Look at this rit:'
			) }</strong> aight`,
		},
	},

	edit: ( { className, attributes, setAttributes } ) => {
		const { content } = attributes;

		return (
			<div className={ className }>
				<RichText
					multiline="p"
					value={ content }
					onChange={ ( value ) =>
						setAttributes( { content: value } )
					}
				/>
			</div>
		);
	},

	save: ( { attributes } ) => (
		<div>
			<RichText.Content value={ attributes.content } />
		</div>
	),
} );
