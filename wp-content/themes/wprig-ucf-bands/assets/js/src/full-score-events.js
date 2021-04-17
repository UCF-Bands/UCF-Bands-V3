/**
 * Full Score Events plugin helpers
 *
 * @since 3.0.0
 */

if ( 'loading' === document.readyState ) {
	// The DOM has not yet been loaded.
	document.addEventListener( 'DOMContentLoaded', initFSE );
} else {
	// The DOM has already been loaded.
	initFSE();
}

function initFSE() {
	// get all upcoming events blocks that are widely-aligned as a last child of
	// a jumbo or banner cover.
	// @todo the margin this adds (negatively) causis bad CLS!
	document.querySelectorAll( `
		.wp-block-cover.is-style-banner .fse-upcoming-events.alignwide:last-child,
		.wp-block-cover.is-style-jumbo .fse-upcoming-events.alignwide:last-child
	` ).forEach( ( block ) => {
		block.closest( '.wp-block-cover' ).classList.add( 'kb-has-upcoming-events-offset' );
	} );
}
