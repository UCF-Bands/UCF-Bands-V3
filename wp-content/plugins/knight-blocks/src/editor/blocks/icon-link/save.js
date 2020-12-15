/**
 * Icon/arrow link block save
 *
 * @since 1.0.0
 */
import { Fragment } from '@wordpress/element';
import { RichText } from '@wordpress/block-editor';

export default function save( { attributes } ) {
	const { text, icon, iconPosition } = attributes;

	return (
		<Fragment>
			<RichText.Content
				tagName="span"
				className="icon-link-text"
				value={ text }
			/>
			<i
				className={ `far fa-${ icon } icon-position-${ iconPosition }` }
				data-icon={ icon }
			/>
		</Fragment>
	);
}
