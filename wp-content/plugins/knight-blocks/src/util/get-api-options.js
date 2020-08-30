/**
 * Get label/value pairs from WP API request for react-select options
 *
 * @see     https://react-select.com/async
 * @since   1.0.0
 * @package Knight_Blocks
 */

const { addQueryArgs } = wp.url;
const { apiFetch } = wp;

// fetch abort controller and flags
let controller = new window.AbortController();
let signal = controller.signal;
let currentFetch = null;
let isFetching = false;

/**
 * Get result from API and format for react-select options
 *
 * @param {string}   endpoint REST API endpoint
 * @param {string}   search   searched value
 * @param {callback} callback link back to react-select
 *
 * @since 1.0.0
 */
const getApiOptions = ( endpoint, search, callback ) => {
	// cut off existing API fetch and set up a new abort controller.
	if ( currentFetch && isFetching ) {
		controller.abort();
		controller = new window.AbortController();
		signal = controller.signal;
	}

	// if we've gotten this far, we're fetching #StopTryingToMakeFetchHappen
	isFetching = true;

	currentFetch = apiFetch( {
		path: addQueryArgs(
			`/wp/v2/${ endpoint }`,
			{ search: encodeURIComponent( search ) }
		),
		signal,
	} ).then( ( response ) => {
		// reset flag and init options array
		isFetching = false;
		const options = [];

		// format the options
		response.forEeach( ( item ) => {
			options.push( {
				label: item.title.rendered,
				value: item.id,
			} );
		} );

		callback( options );
	} ).catch( ( error ) => {
		
	} );
}

export default getApiOptions;
