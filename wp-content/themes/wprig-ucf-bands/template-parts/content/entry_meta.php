<?php
/**
 * Template part for displaying a post's metadata
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

$post_type_obj = get_post_type_object( get_post_type() );
$time_string   = '';
$staff_string  = '';

if ( 'post' === $post_type_obj->name ) {

	$time_string .= sprintf(
		'<time class="entry-date" datetime="%1$s">%2$s</time>',
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

} elseif ( 'fse_staff' === $post_type_obj->name ) {
	global $fse_staff_member;
	$staff_string = $fse_staff_member->get_position();
}
?>

<p class="entry-meta">
	<?php if ( $time_string ) : ?>
		<span class="posted-on"><i class="far fa-calendar-alt"></i><?php echo $time_string; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
	<?php endif; ?>

	<?php if ( $staff_string ) : ?>
		<strong><?php echo $staff_string; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
	<?php endif; ?>
</p>
