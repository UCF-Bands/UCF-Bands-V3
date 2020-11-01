<?php
/**
 * Product block template
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

global $knight_blocks_product;

// False positive.
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
$price    = $knight_blocks_product->get_price();
$shop_url = $knight_blocks_product->get_shop_url();
// phpcs:enable
?>

<figure>
	<div class="product-thumbnail-wrap">
		<?php the_post_thumbnail( 'medium' ); ?>
	</div>

	<figcaption>
		<strong><?php $knight_blocks_product->do_title(); ?></strong>
		<?php if ( $price ) : ?>
			<span class="product-price"><?php echo esc_html( $price ); ?></span>
		<?php endif; ?>
	</figcaption>

	<?php if ( $shop_url ) : ?>
		<a href="<?php echo esc_url( $shop_url ); ?>" class="link-overlay">
			<span class="screen-reader-text"><?php esc_html_e( 'Purchase or view more details', 'knight-blocks' ); ?></span>
		</a>
	<?php endif; ?>
</figure>
