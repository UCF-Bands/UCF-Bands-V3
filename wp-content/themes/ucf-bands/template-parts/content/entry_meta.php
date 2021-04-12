<?php
/**
 * Template part for displaying a post's metadata
 *
 * @package ucf_bands
 */

namespace WP_Rig\WP_Rig;

$post_type_obj = get_post_type_object( get_post_type() );
$time_string   = '';

if ( 'post' === $post_type_obj->name ) {

	$time_string .= sprintf(
		'<time class="entry-date" datetime="%1$s">%2$s</time>',
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
}

?>
<p class="entry-meta">
	<?php if ( $time_string ) : ?>
		<span class="posted-on"><i class="far fa-calendar-alt"></i><?php echo $time_string; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
	<?php endif; ?>
</p>
