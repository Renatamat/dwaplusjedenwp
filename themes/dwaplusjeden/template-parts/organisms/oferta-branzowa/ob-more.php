<?php
/**
 * Offer industry related services.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) || ! get_field( 'ob_more_enabled' ) ) {
	return;
}

$heading = get_field( 'ob_more_heading' );
$items   = get_field( 'ob_more_items' );

if ( ! $items ) {
	return;
}
?>

<section class="od-more pb-56 pb-sm-64 pb-lg-96 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="ob-more-heading"' : ''; ?>>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php if ( $heading ) : ?>
					<h2 id="ob-more-heading" class="p-l fw-bolder d-block w-100 text-center c-body"><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>
			</div>
		</div>
		<div class="row">
			<div class="col-12 offset-xxxl-1 col-xxxl-10">
				<div class="od-more-slider swiper" data-swiper data-swiper-options='{"slidesPerView": "auto", "centeredSlides": true, "spaceBetween": 16, "breakpoints": {"576": {"spaceBetween": 24}, "1200": {"slidesPerView": 3, "centeredSlides": false, "freeMode": false, "spaceBetween": 24}}}'>
					<div class="swiper-wrapper a-card-sequence" data-animate-start="top 90%" data-animate-batch-max="4">
						<?php foreach ( $items as $item ) : ?>
							<?php $link = dwaplusjeden_get_relation_or_link( $item['related_page'], $item['link'] ); ?>
							<?php if ( $link ) : ?>
								<a<?php dwaplusjeden_link_attrs( $link ); ?> class="service-card swiper-slide a-card-item">
							<?php else : ?>
								<div class="service-card swiper-slide a-card-item">
							<?php endif; ?>
								<div class="service-card-wrapper">
									<div class="service-card-img">
										<?php dwaplusjeden_image( $item['icon'], 'thumbnail', 'service1.svg', $item['title'] ); ?>
									</div>
									<div class="d-flex flex-column gap-20">
										<div class="d-flex flex-column gap-8 service-card-content">
											<?php if ( $item['title'] ) : ?>
												<h3 class="p-m fw-bolder c-body"><?php echo esc_html( $item['title'] ); ?></h3>
											<?php endif; ?>
											<?php if ( $item['text'] ) : ?>
												<p class="p-s"><?php echo esc_html( $item['text'] ); ?></p>
											<?php endif; ?>
										</div>
										<div class="c-btn c-btn-s c-btn-text w-100 justify-content-between service-card-button">
											<span class="p-0"><?php echo esc_html( $item['button_label'] ?: __( 'Sprawdź', 'dwaplusjeden' ) ); ?></span>
											<svg class="i-sprite icon-16" aria-hidden="true" focusable="false">
												<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-16.svg' ) ); ?>#arrow_right_2"></use>
											</svg>
										</div>
									</div>
								</div>
							<?php if ( $link ) : ?>
								</a>
							<?php else : ?>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
					<div class="swiper-pagination"></div>
				</div>
			</div>
		</div>
	</div>
</section>
