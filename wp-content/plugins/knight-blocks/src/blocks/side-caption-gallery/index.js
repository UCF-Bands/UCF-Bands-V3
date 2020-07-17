/**
 * Side-captioned gallery block
 *
 * @since   1.0.0
 * @package Knight Blocks
 */

// import './editor.scss';
// import './style.scss';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { InnerBlocks } = wp.blockEditor;

const BLOCKS_TEMPLATE = [
	[ 'core/image' ],
	[ 'core/image' ],
	[ 'core/image' ],
	[ 'core/image' ],
];

const ALLOWED_BLOCKS = [
	'core/image',
];

/**
 * Register side-captioned gallery block.
 *
 * @link   https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'knight-blocks/side-caption-gallery', {
	title: __( 'Side-Captioned Gallery' ),
	icon: 'format-gallery',
	category: 'common',
	keywords: [
		__( 'knight blocks' ),
		__( 'Side Caption Gallery' ),
		__( 'gallery' ),
	],

	/**
	 * Block edit
	 *
	 * @param   {Object} props Props.
	 * @returns {Mixed}  JSX Component.
	 */
	edit: ( props ) => {
		// const { attributes } = props;

		return (
			<section>
				<InnerBlocks
					template={ BLOCKS_TEMPLATE }
					templateLock={ false }
					allowedBlocks={ ALLOWED_BLOCKS }
				/>
			</section>
		);
	},

	/**
	 * Block save
	 *
	 * @param   {Object} props Props.
	 * @returns {Mixed}  JSX Frontend HTML.
	 */
	save: () => {
		return <InnerBlocks.Content />;
	},
} );
