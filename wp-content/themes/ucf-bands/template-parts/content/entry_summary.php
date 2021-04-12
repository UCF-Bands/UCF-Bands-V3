<?php
/**
 * Template part for displaying a post's summary
 *
 * @since   3.0.0
 * @package ucf_bands
 */

namespace WP_Rig\WP_Rig;

$this_type_object = get_post_type_object( get_post_type() );
$icon_link_text   = 'post' === $this_type_object->name
	? __( 'Read more', 'ucf-bands' )
	// Translators: View %type%.
	: sprintf( __( 'View %s', 'ucf-bands' ), $this_type_object->labels->singular_name );
?>

<div class="entry-summary">
	<?php the_excerpt(); ?>

	<p class="excerpt-more">
		<a href="<?php the_permalink(); ?>" class="icon-link">
			<?php echo esc_html( $icon_link_text ); ?>
			<i class="far fa-long-arrow-alt-right"></i>
		</a>
	</p>
</div>
