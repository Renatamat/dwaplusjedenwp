<?php
/**
 * Blog single CTA section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) ) {
	return;
}

$heading        = get_field( 'help_cta_heading', 'option' );
$text           = get_field( 'help_cta_text', 'option' );
$primary_link   = get_field( 'help_cta_primary_link', 'option' );
$secondary_link = get_field( 'help_cta_secondary_link', 'option' );

$heading        = is_scalar( $heading ) ? (string) $heading : '';
$text           = is_scalar( $text ) ? (string) $text : '';
$primary_link   = is_array( $primary_link ) ? $primary_link : array();
$secondary_link = is_array( $secondary_link ) ? $secondary_link : array();

if ( ! $heading && ! $text && empty( $primary_link['url'] ) && empty( $secondary_link['url'] ) ) {
	return;
}
?>

<section class="blog-single-cta pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="blog-single-cta-heading"' : ''; ?>>
	<div class="container">
		<?php if ( $heading || $text ) : ?>
			<div class="row">
				<div class="col-12">
					<div class="d-flex flex-column gap-24 justify-content-center">
						<?php if ( $heading ) : ?>
							<h2 id="blog-single-cta-heading" class="h5 fw-bolder c-white text-center"><?php echo wp_kses_post( $heading ); ?></h2>
						<?php endif; ?>

						<?php if ( $text ) : ?>
							<p class="p-l fw-bolder c-white text-center"><?php echo wp_kses_post( $text ); ?></p>
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
							<a<?php dwaplusjeden_link_attrs( $secondary_link ); ?> class="c-btn c-btn-s c-btn-outline --white w-100">
								<span><?php echo esc_html( $secondary_link['title'] ?: $secondary_link['url'] ); ?></span>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
