/**
 * TablePress "Add to Gravity form list" public scripts
 *
 * @since 0.1.0
 */

import { addQueryArgs } from '@wordpress/url';

if ( 'loading' === document.readyState ) {
	document.addEventListener( 'DOMContentLoaded', initTablePressAddToGformPublic );
} else {
	initTablePressAddToGformPublic();
}

/**
 * Handle checkbox submit
 *
 * @since 0.1.0
 */
function initTablePressAddToGformPublic() {
	const $ = jQuery,
		$submit = $( '.tp-add-to-gform-list-submit' );

	if ( $submit.length < 1 ) {
		return;
	}

	$submit.on( 'click', doCheckboxesSubmit );

	/**
	 * Gather selected values and redirect to URL with defined paramter
	 *
	 * @since 0.1.0
	 */
	function doCheckboxesSubmit() {
		const $this = $(this),
			$table = $( $this.data( 'tp-add-to-gform-list-for' ) );

		if ( $table.length < 1 ) {
			return;
		}

		// Get checked checkboxes.
		const $checkedRows = $( '.tp-add-to-gform-list-checkbox:checked', $table );

		if ( $checkedRows.length < 1 ) {
			return;
		}

		const values = [];

		// Grab the value of each checkbox.
		$checkedRows.each( ( index, checkbox ) => {
			values.push( checkbox.value )
		} );

		// Build the URL with params and redirect.
		const url = $this.data( 'tp-add-to-gform-list-url'),
			fieldName = $this.data( 'tp-add-to-gform-list-field-name' );

		window.location.href = addQueryArgs( url, { [fieldName]: values } );
	}
}
