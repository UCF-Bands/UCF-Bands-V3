/**
 * Does the class(es) string have the block style?
 *
 * @since 1.0.0
 *
 * @param  {string}   className className to check
 * @param  {string}   styleName block style "name" to find
 * @return {boolean}            .is-style-%styleName% is in the className
 */
const hasBlockStyle = ( className, styleName ) => {
	return className && className.includes( `is-style-${ styleName }` );
};

export default hasBlockStyle;
