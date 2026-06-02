<?php
/**
 * Field offer related services.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$has_acf = function_exists( 'get_field' );

if ( $has_acf && false === get_field( 'od_more_enabled' ) ) {
	return;
}

$heading      = $has_acf ? get_field( 'od_more_heading' ) : '';
$related      = $has_acf ? get_field( 'od_more_related_pages' ) : array();

if ( ! $related ) {
	return;
}
?>

<section class="od-more pb-56 pb-sm-64 pb-lg-96 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="od-more-heading"' : ''; ?>>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php if ( $heading ) : ?>
					<h2 id="od-more-heading" class="p-l fw-bolder d-block w-100 text-center c-body"><?php echo wp_kses_post( $heading ); ?></h2>
				<?php endif; ?>
			</div>
		</div>

		<div class="row">
			<div class="col-12 offset-xxxl-1 col-xxxl-10">
				<div
					class="od-more-slider swiper"
					data-swiper
					data-swiper-options='{"slidesPerView": "auto", "centeredSlides": true, "spaceBetween": 16, "breakpoints": {"576": {"spaceBetween": 24}, "1200": {"slidesPerView": 3, "centeredSlides": false, "freeMode": false, "spaceBetween": 24}}}'
				>
					<div class="swiper-wrapper a-card-sequence" data-animate-start="top 90%" data-animate-batch-max="4">
						<?php foreach ( $related as $related_page ) : ?>
							<?php
							$page_id = $related_page instanceof WP_Post ? $related_page->ID : (int) $related_page;

							if ( ! $page_id ) {
								continue;
							}

							$card_icon  = $has_acf ? get_field( 'page_card_icon', $page_id ) : 0;
							$card_title = $has_acf ? get_field( 'page_card_title', $page_id ) : '';
							$card_text  = $has_acf ? get_field( 'page_card_text', $page_id ) : '';

							if ( ! $card_icon && ! $card_title && ! $card_text ) {
								continue;
							}
							?>
							<a href="<?php echo esc_url( get_permalink( $page_id ) ); ?>" class="service-card swiper-slide a-card-item">
								<div class="service-card-wrapper">
									<?php if ( $card_icon ) : ?>
										<div class="service-card-img">
											<?php echo wp_get_attachment_image( $card_icon, 'thumbnail', false, array( 'alt' => wp_strip_all_tags( $card_title ) ) ); ?>
										</div>
									<?php endif; ?>
									<div class="d-flex flex-column gap-20">
										<div class="d-flex flex-column gap-8 service-card-content">
											<?php if ( $card_title ) : ?>
												<h3 class="p-m fw-bolder c-body"><?php echo wp_kses_post( $card_title ); ?></h3>
											<?php endif; ?>
											<?php if ( $card_text ) : ?>
												<p class="p-s"><?php echo wp_kses_post( $card_text ); ?></p>
											<?php endif; ?>
										</div>

										<div class="c-btn c-btn-s c-btn-text w-100 justify-content-between service-card-button">
											<span class="p-0"><?php esc_html_e( 'Sprawdź', 'dwaplusjeden' ); ?></span>
											<svg class="i-sprite icon-16" aria-hidden="true" focusable="false">
												<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-16.svg' ) ); ?>#arrow_right_2"></use>
											</svg>
										</div>
									</div>
								</div>
							</a>
						<?php endforeach; ?>
					</div>
					<div class="swiper-pagination"></div>
				</div>
			</div>
		</div>
	</div>
</section>
