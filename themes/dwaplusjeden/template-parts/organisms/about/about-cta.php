<?php
/**
 * About page CTA.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$has_acf = function_exists( 'get_field' );

if ( $has_acf && false === get_field( 'about_cta_enabled' ) ) {
	return;
}

$cta = $has_acf ? get_field( 'about_cta' ) : array();
$cta = is_array( $cta ) ? $cta : array();

$heading        = isset( $cta['heading'] ) ? $cta['heading'] : '';
$text           = isset( $cta['text'] ) ? $cta['text'] : '';
$primary_link   = isset( $cta['primary_link'] ) && is_array( $cta['primary_link'] ) ? $cta['primary_link'] : array();
$secondary_link = isset( $cta['secondary_link'] ) && is_array( $cta['secondary_link'] ) ? $cta['secondary_link'] : array();
$heading = is_scalar( $heading ) ? (string) $heading : '';
$text    = is_scalar( $text ) ? (string) $text : '';

if ( ! $heading && ! $text && empty( $primary_link['url'] ) && empty( $secondary_link['url'] ) ) {
	return;
}
?>

<section class="about-cta pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-0 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="about-cta-heading"' : ''; ?>>
	<div class="container">
		<?php if ( $heading || $text ) : ?>
			<div class="row">
				<div class="col-12">
					<div class="d-flex flex-column gap-24 justify-content-center">
						<?php if ( $heading ) : ?>
							<h2 id="about-cta-heading" class="h5 fw-bolder c-body text-center"><?php echo wp_kses_post( $heading ); ?></h2>
						<?php endif; ?>
						<?php if ( $text ) : ?>
							<p class="p-l fw-bolder c-body text-center"><?php echo wp_kses_post( $text ); ?></p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $primary_link['url'] ) || ! empty( $secondary_link['url'] ) ) : ?>
			<div class="row mt-32">
				<div class="col-sm-10 col-md-8 col-xl-6 col-xxl-5 mx-auto">
					<div class="d-flex flex-column flex-lg-row gap-16 gap-lg-24">
						<?php if ( ! empty( $primary_link['url'] ) ) : ?>
							<a<?php dwaplusjeden_link_attrs( $primary_link ); ?> class="c-btn c-btn-s c-btn-fill w-100">
								<span><?php echo esc_html( $primary_link['title'] ?: $primary_link['url'] ); ?></span>
							</a>
						<?php endif; ?>
						<?php if ( ! empty( $secondary_link['url'] ) ) : ?>
							<a<?php dwaplusjeden_link_attrs( $secondary_link ); ?> class="c-btn c-btn-s c-btn-outline w-100">
								<span><?php echo esc_html( $secondary_link['title'] ?: $secondary_link['url'] ); ?></span>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
