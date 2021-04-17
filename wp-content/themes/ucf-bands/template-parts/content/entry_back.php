<?php
/**
 * Template part for NOT displaying the "back link" on a page.
 *
 * @since   3.0.0
 * @package ucf_bands
 */

namespace WP_Rig\WP_Rig;

use function \Full_Score_Events\instance as fse;

$this_post_type = get_post_type();
$post_type_obj  = get_post_type_object( $this_post_type );

// Only show on staff member or post types with an archive.
if ( 'fse_staff' === $this_post_type ) {
	$staff_group      = fse()->staff_groups::get_current_terms()[0] ?? false;
	$staff_group_page = $staff_group ? fse()->staff_groups::get_associated_page( $staff_group ) : false;
	$edit_link        = get_edit_post_link();

	if ( ! $edit_link && ! $staff_group_page ) {
		return;
	}
} elseif ( 'post' !== $this_post_type && ! $post_type_obj->has_archive ) {
	return;
}

$url = get_post_type_archive_link( $this_post_type );

switch ( $this_post_type ) {
	case 'post':
		$text = __( 'Announcements', 'ucf-bands' );
		break;

	case 'fse_staff':
		$text = $staff_group ? $staff_group->name : __( '[Editor Only] Assign this staff member a staff group with an "Associated Page"', 'ucf-bands' );
		$url  = $staff_group ? get_permalink( $staff_group_page ) : $edit_link;
		break;

	default:
		$text = $post_type_obj->labels->name;
		break;
}
?>

<nav class="wrap entry-back-wrap">
	<a href="<?php echo esc_url( $url ); ?>" class="entry-back icon-link"><i class="far fa-long-arrow-alt-left icon-position-left"></i><?php echo esc_html( $text ); ?></a>
	<hr>
</nav>
