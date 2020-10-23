/**
 * Arrow link block save
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */
const { Fragment } = wp.element;
const { RichText } = wp.blockEditor;

export default function save( { attributes } ) {
	const { text } = attributes;

	return (
		<Fragment>
			<RichText.Content
				tagName="span"
				className="arrow-link-text"
				value={ text }
			/>
			<i className="far fa-long-arrow-right" />
		</Fragment>
	);
}
