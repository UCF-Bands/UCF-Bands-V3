<?php
/**
 * Template part for displaying a post in a posts loop.
 *
 * @since   3.0.0
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$this_post_type = get_post_type();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
	<?php
	get_template_part( 'template-parts/content/entry_header', $this_post_type );
	get_template_part( 'template-parts/content/entry_summary', $this_post_type );
	?>
</article><!-- #post-<?php the_ID(); ?> -->
