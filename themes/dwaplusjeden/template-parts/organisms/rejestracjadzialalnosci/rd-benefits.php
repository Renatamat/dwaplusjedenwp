<?php
/**
 * Registration page benefits section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) || false === get_field( 'rd_benefits_enabled' ) ) {
	return;
}

$heading = get_field( 'rd_benefits_heading' );
$items   = get_field( 'rd_benefits_items' );

if ( ! $heading && ! $items ) {
	return;
}
?>

<section class="rd-benefits pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="rd-benefits-heading"' : ''; ?>>
	<div class="container">
		<?php if ( $heading ) : ?>
			<div class="row">
				<div class="col-12">
					<h2 id="rd-benefits-heading" class="h5 fw-bolder w-100 text-center c-body"><?php echo wp_kses_post( $heading ); ?></h2>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $items ) : ?>
			<div class="row mt-32 mt-sm-40 mt-lg-48 mt-xxxl-64">
				<div class="offset-xxxl-1 col-12 col-xxxl-10">
					<div class="rd-benefits-grid a-card-sequence" data-animate-start="top 90%" data-animate-batch-max="2">
						<?php foreach ( $items as $item ) : ?>
							<?php
							$item_title = ! empty( $item['title'] ) ? $item['title'] : '';
							$item_text  = ! empty( $item['text'] ) ? $item['text'] : '';

							if ( ! $item_title && ! $item_text ) {
								continue;
							}
							?>
							<div class="rd-benefits-item a-card-item">
								<div class="d-flex gap-16">
									<div class="rd-benefits-item-icon">
										<svg class="i-sprite icon-16" aria-hidden="true" focusable="false">
											<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-16.svg' ) ); ?>#check"></use>
										</svg>
									</div>
									<div class="d-flex flex-column gap-8">
										<?php if ( $item_title ) : ?>
											<h3 class="p-m fw-bolder c-body"><?php echo wp_kses_post( $item_title ); ?></h3>
										<?php endif; ?>
										<?php if ( $item_text ) : ?>
											<p class="p-s"><?php echo wp_kses_post( $item_text ); ?></p>
										<?php endif; ?>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
