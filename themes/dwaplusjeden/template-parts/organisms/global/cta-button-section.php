<?php
/**
 * Reusable CTA button section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$has_acf = function_exists( 'get_field' );
$prefix  = ! empty( $args['field_prefix'] ) ? $args['field_prefix'] : 'cta_button';

if ( $has_acf && false === get_field( $prefix . '_enabled' ) ) {
	return;
}

$heading        = $has_acf ? get_field( $prefix . '_heading' ) : '';
$text           = $has_acf ? get_field( $prefix . '_text' ) : '';
$primary_link   = $has_acf ? dwaplusjeden_get_acf_link( $prefix . '_primary_link', get_the_ID() ) : array();
$secondary_link = $has_acf ? dwaplusjeden_get_acf_link( $prefix . '_secondary_link', get_the_ID() ) : array();
$image          = $has_acf ? get_field( $prefix . '_image' ) : 0;

if ( ! $heading && ! $text && empty( $primary_link['url'] ) && empty( $secondary_link['url'] ) && ! $image ) {
	return;
}
?>

<section class="hp-cta pt-56 pb-56 pt-lg-96 pb-lg-96"<?php echo $heading ? ' aria-labelledby="' . esc_attr( $prefix ) . '-heading"' : ''; ?>>
	<div class="container">
		<div class="row r-gap-24">
			<div class="offset-xxxl-1 col-lg-5 col-xxxl-4 order-2 order-lg-1 d-flex align-items-center">
				<div class="d-flex flex-column gap-48">
					<div class="d-flex flex-column gap-24">
						<?php if ( $heading ) : ?>
							<h2 id="<?php echo esc_attr( $prefix ); ?>-heading" class="h6 fw-bolder c-white a-slide-left" data-animate-delay="0.06">
								<?php echo wp_kses_post( $heading ); ?>
							</h2>
						<?php endif; ?>

						<?php if ( $text ) : ?>
							<p class="p-m c-white a-slide-left" data-animate-delay="0.09"><?php echo wp_kses_post( $text ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $primary_link['url'] ) || ! empty( $secondary_link['url'] ) ) : ?>
							<div class="d-flex flex-column flex-sm-row gap-24 a-slide-left" data-animate-delay="0.12">
								<?php if ( ! empty( $primary_link['url'] ) ) : ?>
									<a<?php dwaplusjeden_link_attrs( $primary_link ); ?> class="c-btn c-btn-s c-btn-fill w-100">
										<span><?php echo esc_html( $primary_link['title'] ?: $primary_link['url'] ); ?></span>
									</a>
								<?php endif; ?>

								<?php if ( ! empty( $secondary_link['url'] ) ) : ?>
									<a<?php dwaplusjeden_link_attrs( $secondary_link ); ?> class="c-btn c-btn-s c-btn-outline --white w-100">
										<span><?php echo esc_html( $secondary_link['title'] ?: $secondary_link['url'] ); ?></span>
									</a>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<?php if ( $image ) : ?>
				<div class="offset-lg-1 col-lg-6 order-1 order-lg-2">
					<div class="position-relative">
						<?php dwaplusjeden_image( $image, 'full' ); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
