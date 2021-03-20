<?php
/**
 * Ordered process step dynamic block template
 *
 * @since   1.0.0
 * @package Knight_Blocks
 */

use function Knight_Blocks\get_allowed_inline_html;

$is_active   = 'active' === $status;
$is_download = 'download' === $type;
$is_static   = 'static' === $type;
?>

<figure class="wp-block-knight-blocks-ordered-process-step ordered-process-step-status-<?php echo esc_attr( $status ); ?>">

	<div class="ordered-process-step-number">
		<span class="ordered-process-step-status-circle">
			<?php
			/* translators: Step is %s */
			printf( esc_html__( 'Step is %s', 'knight-blocks' ), esc_html( $status ) );
			?>
		</span>
	</div>

	<figcaption>
		<?php if ( $title ) : ?>
			<h4 class="h6 ordered-process-step-title">
				<?php if ( $is_active && $url && ! $is_static ) : ?>
					<a
						href="<?php echo esc_url( $url ); ?>"
						<?php echo esc_attr( $is_download ? 'download' : '' ); ?>
					>
				<?php endif; ?>

				<?php echo esc_html( $title ); ?>

				<?php if ( $is_active && $url && ! $is_static ) : ?>
					<i class="far fa-<?php echo esc_html( $is_download ? 'download' : 'long-arrow-alt-right' ); ?>"></i></a>
				<?php endif; ?>
			</h4>
		<?php endif; ?>

		<?php if ( $description ) : ?>
			<p><?php echo wp_kses( $description, get_allowed_inline_html() ); ?></p>
		<?php endif; ?>
	</figcaption>
</figure>
