/**
 * Full Score Events plugin helpers
 *
 * @since 1.0.0
 */

initFSE();

function initFSE() {
	// get all upcoming events blocks that are widely-aligned as a last child of
	// a jumbo or banner cover.
	document.querySelectorAll( `
		.wp-block-cover.is-style-banner .fse-upcoming-events.alignwide:last-child,
		.wp-block-cover.is-style-jumbo .fse-upcoming-events.alignwide:last-child
	` ).forEach( ( block ) => {
		block.closest( '.wp-block-cover' ).classList.add( 'kb-has-upcoming-events-offset' );
	} );
}
