/**
 * Higher order component for wrapping a block in an anchor.
 *
 * @see     https://jschof.com/gutenberg-blocks/sharing-functionality-between-gutenberg-blocks/
 * @since   1.0.0
 * @package Knight_Blocks
 */

import URLPicker from '../../util/url-picker';

const { Fragment } = wp.element;

/**
 * Edit/save wrapper with url-picker/link functionality.
 *
 * @param  {object} blockConfig   Base block configs that we're adding things to.
 * @return {object} wrappedConfig Base block wrapped in extra URL functionality.
 *
 * @since 1.0.0
 */
const URLWrapper = ( blockConfig ) => {
	const { title, icon, category } = blockConfig;

	const wrappedConfig = {
		// keep things from the original config
		title,
		icon,
		category,

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
		 * @param  {object} props Block properties for editing.
		 * @return {object}       Link-functionality-wrapped block edit
		 *
		 * @since 1.0.0
		 */
		edit: ( props ) => {
			const { setAttributes, attributes, isSelected } = props;
			const { url, linkTarget, rel } = attributes;

			return <Fragment>
				<URLPicker
					url={ url }
					rel={ rel }
					setAttributes={ setAttributes }
					isSelected={ isSelected }
					opensInNewTab={ linkTarget === '_blank' }
				/>

				{ /* eslint-disable jsx-a11y/anchor-is-valid */ }
				<a href="#">
					{ /* eslint-enable jsx/a11y/anchor-is-valid */ }
					{ blockConfig.edit( props ) }
				</a>
			</Fragment>;
		},

		/**
		 * Save function that wraps the original block in the link functionality
		 *
		 * @param  {object} props Block properties.
		 * @return {object}       Link-wrapped block
		 *
		 * @since 1.0.0
		 */
		save: ( props ) => {
			const { url, linkTarget, rel } = props.attributes;

			return <a
				href={ url }
				target={ linkTarget }
				rel={ rel }
			>
				{ blockConfig.save( props ) }
			</a>;
		},
	};

	return wrappedConfig;
};

export default URLWrapper;
