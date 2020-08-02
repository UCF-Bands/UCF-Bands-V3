/**
 * Gutenberg Blocks
 *
 * All blocks related JavaScript files should be imported here.
 * You can create a new block folder in this dir and include code
 * for that block here as well.
 *
 * All blocks should be included here since this is the file that
 * Webpack is compiling as the input file.
 */

// editor and editor + front end shared styling (common.scss bug)
import './shared/style-imports';

// utilities (helpers, global filters)
import './util/has-block-style';

// wp/core extensions
import './blocks/core/paragraph';
import './blocks/core/list';
import './blocks/core/button';
import './blocks/core/cover';

// full custom blocks
import './blocks/block';
import './blocks/side-caption-gallery';
