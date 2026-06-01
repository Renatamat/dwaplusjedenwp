<?php
/**
 * Homepage hero slider.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) || ! get_field( 'homepage_slider_enabled' ) ) {
	return;
}

$slides            = get_field( 'homepage_slider_slides' );
$secondary_message = get_field( 'homepage_slider_secondary_message' );
$secondary_name    = get_field( 'homepage_slider_secondary_name' );
$secondary_role    = get_field( 'homepage_slider_secondary_role' );
$secondary_avatar  = get_field( 'homepage_slider_secondary_avatar' );
$primary_message   = get_field( 'homepage_slider_primary_message' );
$primary_name      = get_field( 'homepage_slider_primary_name' );
$primary_role      = get_field( 'homepage_slider_primary_role' );
$primary_avatar    = get_field( 'homepage_slider_primary_avatar' );

if ( ! $slides ) {
	return;
}
?>

<section class="hp-hero-slider">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="position-relative">
					<div class="hp-hero-slider-wrapper swiper" data-swiper data-swiper-options='{"slidesPerView": 1, "loop": true}'>
						<div class="swiper-wrapper">
							<?php foreach ( $slides as $slide ) : ?>
								<div class="swiper-slide">
									<?php dwaplusjeden_image( $slide['image'], 'full', 'slider1.jpg', ! empty( $slide['alt'] ) ? $slide['alt'] : '' ); ?>
								</div>
							<?php endforeach; ?>
						</div>
						<div class="swiper-pagination"></div>
					</div>

					<?php if ( $secondary_message || $secondary_name || $secondary_role ) : ?>
						<div class="hp-hero-slider-message --secondary a-bubble-pop" data-animate-start="top 60%" data-animate-delay="0.18">
							<div class="hp-hero-slider-message-wrapper">
								<div class="d-flex flex-column gap-16">
									<?php if ( $secondary_message ) : ?>
										<p class="p-s"><?php echo esc_html( $secondary_message ); ?></p>
									<?php endif; ?>
									<div class="d-flex flex-column">
										<?php if ( $secondary_name ) : ?>
											<span class="p-s fw-bolder c-body"><?php echo esc_html( $secondary_name ); ?></span>
										<?php endif; ?>
										<?php if ( $secondary_role ) : ?>
											<span class="p-overline c-black"><?php echo esc_html( $secondary_role ); ?></span>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<div class="hero-slider-avatar">
								<div class="avatar">
									<div class="avatar-wrapper">
										<?php dwaplusjeden_image( $secondary_avatar, 'thumbnail', 'person.jpg' ); ?>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>

					<?php if ( $primary_message || $primary_name || $primary_role ) : ?>
						<div class="hp-hero-slider-message --primary a-bubble-pop" data-animate-delay="0.24">
							<div class="hp-hero-slider-message-wrapper">
								<div class="d-flex flex-column gap-16">
									<?php if ( $primary_message ) : ?>
										<p class="p-m"><?php echo esc_html( $primary_message ); ?></p>
									<?php endif; ?>
									<div class="d-flex flex-column">
										<?php if ( $primary_name ) : ?>
											<span class="p-s fw-bolder c-body"><?php echo esc_html( $primary_name ); ?></span>
										<?php endif; ?>
										<?php if ( $primary_role ) : ?>
											<span class="p-overline c-black"><?php echo esc_html( $primary_role ); ?></span>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<div class="hero-slider-avatar">
								<?php dwaplusjeden_image( $primary_avatar, 'thumbnail', 'testimonial.svg' ); ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
