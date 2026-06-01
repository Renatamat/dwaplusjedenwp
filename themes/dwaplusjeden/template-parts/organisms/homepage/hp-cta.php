<?php
/**
 * Homepage CTA.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) || ! get_field( 'homepage_cta_enabled' ) ) {
	return;
}

$heading      = get_field( 'homepage_cta_heading' );
$text         = get_field( 'homepage_cta_text' );
$items        = get_field( 'homepage_cta_items' );
$link         = dwaplusjeden_get_acf_link( 'homepage_cta_link', get_the_ID() );
$image        = get_field( 'homepage_cta_image' );
$bubble_text  = get_field( 'homepage_cta_bubble_text' );
$bubble_name  = get_field( 'homepage_cta_bubble_name' );
$bubble_role  = get_field( 'homepage_cta_bubble_role' );
$bubble_image = get_field( 'homepage_cta_bubble_image' );
?>

<section class="hp-cta pt-56 pb-56 pt-lg-96 pb-lg-96"<?php echo $heading ? ' aria-labelledby="homepage-cta-heading"' : ''; ?>>
	<div class="container">
		<div class="row r-gap-24">
			<div class="col-lg-5 order-2 order-lg-1 d-flex align-items-center">
				<div class="d-flex flex-column gap-48">
					<div class="d-flex flex-column gap-24 hp-cta-content">
						<?php if ( $heading ) : ?>
							<h2 id="homepage-cta-heading" class="h6 fw-bolder c-white a-slide-left"><?php echo esc_html( $heading ); ?></h2>
						<?php endif; ?>
						<?php if ( $text ) : ?>
							<p class="p-m c-white a-slide-left" data-animate-delay="0.06"><?php echo esc_html( $text ); ?></p>
						<?php endif; ?>
						<?php if ( $items ) : ?>
							<div class="d-flex flex-column gap-16">
								<?php foreach ( $items as $index => $item ) : ?>
									<div class="d-flex gap-16 align-items-center a-slide-left" data-animate-delay="<?php echo esc_attr( 0.12 + ( $index * 0.06 ) ); ?>">
										<div class="hp-cta-list-icon">
											<svg class="i-sprite icon-16" aria-hidden="true" focusable="false">
												<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-16.svg' ) ); ?>#check"></use>
											</svg>
										</div>
										<span class="p-m c-white"><?php echo esc_html( $item['text'] ); ?></span>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $link['url'] ) ) : ?>
						<a<?php dwaplusjeden_link_attrs( $link ); ?> class="c-btn c-btn-s c-btn-fill">
							<span><?php echo esc_html( $link['title'] ?: $link['url'] ); ?></span>
						</a>
					<?php endif; ?>
				</div>
			</div>
			<div class="offset-lg-1 col-lg-6 order-1 order-lg-2">
				<div class="position-relative">
					<?php dwaplusjeden_image( $image, 'full', 'cta.png' ); ?>
					<?php if ( $bubble_text || $bubble_name || $bubble_role ) : ?>
						<div class="hp-hero-slider-message a-bubble-pop" data-animate-delay="0.12" data-animate-start="top 82%">
							<div class="hp-hero-slider-message-wrapper">
								<div class="d-flex flex-column gap-16">
									<?php if ( $bubble_text ) : ?>
										<p class="p-s"><?php echo esc_html( $bubble_text ); ?></p>
									<?php endif; ?>
									<div class="d-flex flex-column">
										<?php if ( $bubble_name ) : ?>
											<span class="p-s fw-bolder c-body"><?php echo esc_html( $bubble_name ); ?></span>
										<?php endif; ?>
										<?php if ( $bubble_role ) : ?>
											<span class="p-overline c-black"><?php echo esc_html( $bubble_role ); ?></span>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<div class="hero-slider-avatar">
								<div class="avatar">
									<div class="avatar-wrapper">
										<?php dwaplusjeden_image( $bubble_image, 'thumbnail', 'person.jpg' ); ?>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
