<?php
/**
 * Template part for NOT displaying the "back link" on a page.
 *
 * @since   3.0.0
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$this_post_type = get_post_type();
$post_type_obj  = get_post_type_object( $this_post_type );

// Only show on post types with an archive.
if ( 'post' !== $this_post_type && ! $post_type_obj->has_archive ) {
	return;
}

switch ( $this_post_type ) {
	case 'post':
		$text = __( 'Announcements', 'wp-rig' );
		break;

	default:
		$text = $post_type_obj->labels->name;
		break;
}
?>

<nav class="wrap entry-back-wrap">
	<a href="<?php echo esc_url( get_post_type_archive_link( $this_post_type ) ); ?>" class="icon-link entry-back"><i class="far fa-long-arrow-alt-left"></i><?php echo esc_html( $text ); ?></a>
	<hr>
</nav>
