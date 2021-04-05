<?php
/**
 * Template part for displaying the header's "featured links" (ex: Armory)
 *
 * @since   3.0.0
 * @package wp_rig
 */

foreach ( [
	'armory',
] as $key ) {
	$links[ $key ] = get_permalink( get_theme_mod( "ft_link_$key" ) );
}

// Make sure something came back.
$links = array_filter( $links );

if ( ! $links ) {
	return;
}
?>

<nav class="featured-links">

	<?php if ( $links['armory'] ) : ?>
		<a href="<?php echo esc_url( $links['armory'] ); ?>">
			<?php esc_html_e( 'Armory', 'wp-rig' ); ?>
			<i class="far fa-shield-alt"></i>
		</a>
	<?php endif; ?>

</nav>
