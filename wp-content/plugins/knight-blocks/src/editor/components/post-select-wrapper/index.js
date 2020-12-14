/**
 * Higher order component for wrapping a block in a post selector.
 *
 * @see   https://jschof.com/gutenberg-blocks/sharing-functionality-between-gutenberg-blocks/
 * @since 1.0.0
 */

import AsyncSelect from 'react-select/async';
import getApiOptions from '../../util/get-api-options';

const { __, sprintf } = wp.i18n;
const { Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { PanelBody } = wp.components;

/**
 * Edit/save wrapper with post selection functionality.
 *
 * @param  {Object} blockConfig   Base block configs that we're adding things to.
 * @return {Object} wrappedConfig Base block wrapped in extra post selection functionality.
 *
 * @since 1.0.0
 */
const PostSelectWrapper = ( blockConfig ) => {
	const {
		title,
		description,
		icon,
		category,
		keywords,
		edit,
		save,
		postType,
		selectLabel,
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
			selectedPost: {
				type: 'object',
				default: {
					label: '',
					value: '',
				},
			},

			...blockConfig.attributes,
		},

		/**
		 * Edit function that runs the base block's edit
		 *
		 * @param  {Object} props Block properties for editing.
		 * @return {Object}       post-select-wrapped block edit
		 *
		 * @since 1.0.0
		 */
		edit: ( props ) => {
			const { setAttributes, attributes } = props;
			const { selectedPost } = attributes;

			return (
				<Fragment>
					<InspectorControls>
						<PanelBody
							title={ sprintf(
								// Translators: Select %s
								__( 'Select %s', 'knight-blocks' ),
								selectLabel
							) }
							initialOpen={ true }
						>
							<AsyncSelect
								name="kb-post-select"
								value={ selectedPost }
								onChange={ ( option ) =>
									setAttributes( { selectedPost: option } )
								}
								loadOptions={ ( inputValue, callback ) =>
									getApiOptions(
										postType,
										inputValue,
										callback
									)
								}
								placeholder={ sprintf(
									// Translators: Start typing the name of a %s…
									__(
										'Start typing the name of a %s…',
										'knight-blocks'
									),
									selectLabel
								) }
								noOptionsMessage={ () =>
									sprintf(
										// Translators: No options. Start typing the name of a %s
										__(
											'No options. Start typing the name of a %s',
											'knight-blocks'
										),
										selectLabel
									)
								}
							/>
						</PanelBody>
					</InspectorControls>

					{ edit( props ) }
				</Fragment>
			);
		},

		// we aren't doing anything special with the saved block DOM
		save,
	};

	return wrappedConfig;
};

export default PostSelectWrapper;
