<?php
/**
 * Reusable CTA accordion section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$has_acf = function_exists( 'get_field' );
$prefix  = ! empty( $args['field_prefix'] ) ? $args['field_prefix'] : 'cta';
$is_offer_cta  = in_array( $prefix, array( 'ob_cta', 'od_cta' ), true );
$section_class = $is_offer_cta ? ' ob-cta' : '';

if ( $has_acf && false === get_field( $prefix . '_enabled' ) ) {
	return;
}

$heading      = $has_acf ? get_field( $prefix . '_heading' ) : '';
$items        = $has_acf ? get_field( $prefix . '_items' ) : array();
$link         = $has_acf ? dwaplusjeden_get_acf_link( $prefix . '_link', get_the_ID() ) : array();
$image        = $has_acf ? get_field( $prefix . '_image' ) : 0;
$bubble_text  = $has_acf ? get_field( $prefix . '_bubble_text' ) : '';
$bubble_name  = $has_acf ? get_field( $prefix . '_bubble_name' ) : '';
$bubble_role  = $has_acf ? get_field( $prefix . '_bubble_role' ) : '';
$bubble_image = $has_acf ? get_field( $prefix . '_bubble_image' ) : 0;
$accordion_id = $prefix . '-accordion-' . get_the_ID();
?>

<section class="od-cta pt-56 pb-56 pt-lg-96 pb-lg-96"<?php echo $heading ? ' aria-labelledby="' . esc_attr( $prefix ) . '-heading"' : ''; ?>>
	<div class="container">
		<div class="row r-gap-24">
			<div class="col-lg-6 offset-xxxl-1 col-xxxl-5 order-2 order-lg-1 d-flex align-items-center">
				<div class="d-flex flex-column gap-48">
					<div class="d-flex flex-column gap-24">
						<?php if ( $heading ) : ?>
							<h2 id="<?php echo esc_attr( $prefix ); ?>-heading" class="h6 fw-bolder c-white a-slide-left" data-animate-delay="0.06">
								<?php echo wp_kses_post( $heading ); ?>
							</h2>
						<?php endif; ?>

						<?php if ( $items ) : ?>
							<div class="accordion od-cta-accordion d-flex flex-column gap-24" id="<?php echo esc_attr( $accordion_id ); ?>">
								<?php foreach ( $items as $index => $item ) : ?>
									<?php
									$title       = isset( $item['title'] ) ? $item['title'] : '';
									$text        = isset( $item['text'] ) ? $item['text'] : '';
									$heading_id  = $accordion_id . '-heading-' . $index;
									$collapse_id = $accordion_id . '-collapse-' . $index;
									$delay       = 0.10 + ( $index * 0.04 );
									?>
									<?php if ( $title || $text ) : ?>
										<div class="accordion-item a-slide-left" data-animate-delay="<?php echo esc_attr( number_format( $delay, 2, '.', '' ) ); ?>">
											<h3 class="accordion-header" id="<?php echo esc_attr( $heading_id ); ?>">
												<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr( $collapse_id ); ?>" aria-expanded="false" aria-controls="<?php echo esc_attr( $collapse_id ); ?>">
													<span class="accordion-item-icon">
														<svg class="i-sprite icon-16" aria-hidden="true" focusable="false">
															<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-16.svg' ) ); ?>#chevron_down"></use>
														</svg>
													</span>
													<?php if ( $title ) : ?>
														<span class="p-m fw-bolder c-white"><?php echo wp_kses_post( $title ); ?></span>
													<?php endif; ?>
												</button>
											</h3>
											<div id="<?php echo esc_attr( $collapse_id ); ?>" class="accordion-collapse collapse" aria-labelledby="<?php echo esc_attr( $heading_id ); ?>" data-bs-parent="#<?php echo esc_attr( $accordion_id ); ?>">
												<div class="accordion-body">
													<?php if ( $text ) : ?>
														<p class="p-m c-white"><?php echo wp_kses_post( $text ); ?></p>
													<?php endif; ?>
												</div>
											</div>
										</div>
									<?php endif; ?>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>

					<?php if ( ! empty( $link['url'] ) && ! empty( $link['title'] ) ) : ?>
						<a<?php dwaplusjeden_link_attrs( $link ); ?> class="c-btn c-btn-s c-btn-fill a-slide-left" data-animate-delay="0.14">
							<span><?php echo esc_html( $link['title'] ); ?></span>
						</a>
					<?php endif; ?>
				</div>
			</div>
			<div class="col-lg-6 order-1 order-lg-2">
				<div class="position-relative  <?php echo esc_attr( $section_class ); ?>">
					<?php dwaplusjeden_image( $image, 'full' ); ?>
					<?php if ( $bubble_text || $bubble_name || $bubble_role || $bubble_image ) : ?>
						<div class="hp-hero-slider-message a-bubble-pop" data-animate-delay="0.22" data-animate-start="top 80%">
							<div class="hp-hero-slider-message-wrapper">
								<div class="d-flex flex-column gap-16">
									<?php if ( $bubble_text ) : ?>
										<p class="p-s"><?php echo wp_kses_post( $bubble_text ); ?></p>
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
							<?php if ( $bubble_image ) : ?>
								<div class="hero-slider-avatar">
									<div class="avatar">
										<div class="avatar-wrapper">
											<?php dwaplusjeden_image( $bubble_image, 'thumbnail' ); ?>
										</div>
									</div>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
