/**
 * Higher order component for wrapping a block in an anchor.
 *
 * @see   https://jschof.com/gutenberg-blocks/sharing-functionality-between-gutenberg-blocks/
 * @since 1.0.0
 */

import URLPicker from '../../util/url-picker';

import { useBlockProps } from '@wordpress/block-editor';

/**
 * Edit/save wrapper with url-picker/link functionality.
 *
 * @param  {Object} blockConfig   Base block configs that we're adding things to.
 * @return {Object} wrappedConfig Base block wrapped in extra URL functionality.
 *
 * @since 1.0.0
 */
const URLWrapper = ( blockConfig ) => {
	const {
		title,
		description,
		icon,
		category,
		keywords,
		edit,
		save,
	} = blockConfig;

	const wrappedConfig = {
		// keep things from the original config
		title,
		description,
		icon,
		category,
		keywords,

		// merge in the attributes we want
		attributes: {
			url: {
				type: 'string',
				source: 'attribute',
				selector: 'a',
				attribute: 'href',
			},

			linkTarget: {
				type: 'string',
				source: 'attribute',
				selector: 'a',
				attribute: 'target',
			},

			rel: {
				type: 'string',
				source: 'attribute',
				selector: 'a',
				attribute: 'rel',
			},

			...blockConfig.attributes,
		},

		/**
		 * Edit function that runs the base block's edit
		 *
		 * @param  {Object} props Block properties for editing.
		 * @return {Object}       Link-functionality-wrapped block edit
		 *
		 * @since 1.0.0
		 */
		edit: ( props ) => {
			const { className, setAttributes, attributes, isSelected } = props;
			const { url, linkTarget, rel } = attributes;

			return (
				<>
					<URLPicker
						url={ url }
						rel={ rel }
						setAttributes={ setAttributes }
						isSelected={ isSelected }
						opensInNewTab={ linkTarget === '_blank' }
					/>

					{ /* eslint-disable jsx-a11y/anchor-is-valid */ }
					<a { ...useBlockProps( { href: '#', className } ) }>
						{ edit( props ) }
					</a>
				</>
			);
		},

		/**
		 * Save function that wraps the original block in the link functionality
		 *
		 * @param  {Object} props Block properties.
		 * @return {Object}       Link-wrapped block
		 *
		 * @since 1.0.0
		 */
		save: ( props ) => {
			const { url, linkTarget, rel } = props.attributes;

			return (
				<a
					{ ...useBlockProps.save( {
						href: url,
						target: linkTarget,
						rel,
					} ) }
				>
					{ save( props ) }
				</a>
			);
		},
	};

	return wrappedConfig;
};

export default URLWrapper;
