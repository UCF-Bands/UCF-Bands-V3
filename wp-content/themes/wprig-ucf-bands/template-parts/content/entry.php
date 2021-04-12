<?php
/**
 * Template part for displaying a post
 *
 * @since   3.0.0
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$this_post_type = get_post_type();

?>

<?php get_template_part( 'template-parts/content/entry_back', $this_post_type ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
	<?php
	get_template_part( 'template-parts/content/entry_header', $this_post_type );
	get_template_part( 'template-parts/content/entry_content', $this_post_type );
	get_template_part( 'template-parts/content/entry_footer', $this_post_type );
	?>
</article><!-- #post-<?php the_ID(); ?> -->

<?php
// Show post navigation only when the post type is 'post' or has an archive.
if ( 'post' === $this_post_type || get_post_type_object( $this_post_type )->has_archive ) {
	the_post_navigation(
		[
			'prev_text' => '<div class="post-navigation-sub"><span class="icon-link">' . esc_html__( 'Previous:', 'wp-rig' ) . '</span></div>%title',
			'next_text' => '<div class="post-navigation-sub"><span class="icon-link">' . esc_html__( 'Next:', 'wp-rig' ) . '</span></div>%title',
		]
	);
}

// Show comments only when the post type supports it and when comments are open or at least one comment exists.
if ( post_type_supports( $this_post_type, 'comments' ) && ( comments_open() || get_comments_number() ) ) {
	comments_template();
}
