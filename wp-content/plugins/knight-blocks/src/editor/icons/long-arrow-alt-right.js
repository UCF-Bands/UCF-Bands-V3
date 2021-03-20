/**
 * FontAwesome "long-arrow-alt-right" icon
 *
 * We're using this instead of React FontAwesome since it keeps freaking out
 * about some stupid "24" size prop.
 *
 * @since 1.0.0
 * @todo  See if we can get rid of this ridiculousness
 */

const icon = (
	<svg
		aria-hidden="true"
		focusable="false"
		data-prefix="far"
		data-icon="long-arrow-alt-right"
		className="svg-inline--fa fa-long-arrow-alt-right fa-w-14"
		role="img"
		xmlns="http://www.w3.org/2000/svg"
		viewBox="0 0 448 512"
	>
		<path
			fill="currentColor"
			d="M340.485 366l99.03-99.029c4.686-4.686 4.686-12.284 0-16.971l-99.03-99.029c-7.56-7.56-20.485-2.206-20.485 8.485v71.03H12c-6.627 0-12 5.373-12 12v32c0 6.627 5.373 12 12 12h308v71.03c0 10.689 12.926 16.043 20.485 8.484z"
		></path>
	</svg>
);

export default icon;
