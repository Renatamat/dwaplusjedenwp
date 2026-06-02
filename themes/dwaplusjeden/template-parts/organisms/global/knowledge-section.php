<?php
/**
 * Reusable knowledge section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$has_acf = function_exists( 'get_field' );
$prefix  = ! empty( $args['field_prefix'] ) ? $args['field_prefix'] : 'knowledge';

if ( $has_acf && false === get_field( $prefix . '_enabled' ) ) {
	return;
}

$heading = $has_acf ? get_field( $prefix . '_heading' ) : '';
$items   = $has_acf ? get_field( $prefix . '_items' ) : array();
?>

<section class="od-knowledge pt-56 pb-56 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="' . esc_attr( $prefix ) . '-heading"' : ''; ?>>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php if ( $heading ) : ?>
					<h2 id="<?php echo esc_attr( $prefix ); ?>-heading" class="h5 fw-bolder c-body text-center w-100"><?php echo wp_kses_post( $heading ); ?></h2>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( $items ) : ?>
			<div class="row mt-32 mt-sm-40 mt-lg-48 mt-xxxl-64">
				<div class="offset-lg-1 col-lg-10">
					<div class="d-flex flex-column gap-32 gap-sm-40 gap-lg-48">
						<?php foreach ( $items as $item ) : ?>
							<?php
							$title = isset( $item['title'] ) ? $item['title'] : '';
							$text  = isset( $item['text'] ) ? $item['text'] : '';
							?>
							<?php if ( $title || $text ) : ?>
								<div class="d-flex flex-column">
									<?php if ( $title ) : ?>
										<h3 class="p-m fw-bolder c-body"><?php echo wp_kses_post( $title ); ?></h3>
									<?php endif; ?>
									<?php if ( $text ) : ?>
										<p class="p-m c-body"><?php echo wp_kses_post( $text ); ?></p>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
