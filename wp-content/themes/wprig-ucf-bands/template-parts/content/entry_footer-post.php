<?php
/**
 * Template part for displaying a post's footer
 *
 * @since   3.0.0
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>
<footer class="entry-footer">
	<?php get_template_part( 'template-parts/content/entry_actions', get_post_type() ); ?>
</footer>
