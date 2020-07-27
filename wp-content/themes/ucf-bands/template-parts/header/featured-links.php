<?php
/**
 * Template part for displaying the header's "featured links" (ex: Armory)
 *
 * @since   1.0.0
 * @package ucf_bands
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
			<?php esc_html_e( 'Armory', 'ucf-bands' ); ?>
			<i class="far fa-shield-alt"></i>
		</a>
	<?php endif; ?>

</nav>
