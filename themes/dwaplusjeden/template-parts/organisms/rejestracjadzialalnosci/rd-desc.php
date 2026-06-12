<?php
/**
 * Registration page description section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) || false === get_field( 'rd_desc_enabled' ) ) {
	return;
}

$label        = get_field( 'rd_desc_label' );
$heading      = get_field( 'rd_desc_heading' );
$text         = get_field( 'rd_desc_text' );
$quote_text   = get_field( 'rd_desc_quote_text' );
$quote_author = get_field( 'rd_desc_quote_author' );
$quote_meta   = get_field( 'rd_desc_quote_meta' );
$quote_avatar = get_field( 'rd_desc_quote_avatar' );
$items        = get_field( 'rd_desc_items' );

if ( ! $label && ! $heading && ! $text && ! $quote_text && ! $items ) {
	return;
}

$accordion_id = wp_unique_id( 'rdDescAccordion-' );
?>

<section class="rd-desc pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132">
	<div class="container">
		<?php if ( $label ) : ?>
			<div class="row">
				<div class="col-12">
					<div class="label-red a-slide-left" data-animate-delay="0.06">
						<span class="p-s fw-bolder c-white"><?php echo esc_html( $label ); ?></span>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div class="row mt-24 r-gap-24">
			<div class="col-lg-6">
				<div class="d-flex flex-column gap-32 gap-sm-40 gap-lg-48 gap-xxxl-64 pr-xxxl-64">
					<?php if ( $heading || $text ) : ?>
						<div class="d-flex flex-column gap-24">
							<?php if ( $heading ) : ?>
								<h2 class="h6 fw-bolder c-body a-slide-left" data-animate-delay="0.09"><?php echo wp_kses_post( $heading ); ?></h2>
							<?php endif; ?>
							<?php if ( $text ) : ?>
								<p class="p-m a-slide-left" data-animate-delay="0.09"><?php echo wp_kses_post( $text ); ?></p>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ( $quote_text || $quote_author || $quote_meta || $quote_avatar ) : ?>
						<div class="hp-hero-slider-message --primary a-bubble-pop" data-animate-delay="0.22" data-animate-start="top 80%">
							<div class="hp-hero-slider-message-wrapper">
								<div class="d-flex flex-column gap-16">
									<?php if ( $quote_text ) : ?>
										<p class="p-m"><?php echo wp_kses_post( $quote_text ); ?></p>
									<?php endif; ?>
									<?php if ( $quote_author || $quote_meta ) : ?>
										<div class="d-flex flex-column">
											<?php if ( $quote_author ) : ?>
												<span class="p-s fw-bolder c-body"><?php echo esc_html( $quote_author ); ?></span>
											<?php endif; ?>
											<?php if ( $quote_meta ) : ?>
												<span class="p-overline c-black"><?php echo esc_html( $quote_meta ); ?></span>
											<?php endif; ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
							<?php if ( $quote_avatar ) : ?>
								<div class="hero-slider-avatar">
									<?php dwaplusjeden_image( $quote_avatar, 'thumbnail' ); ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( $items ) : ?>
				<div class="col-lg-6">
					<div class="accordion d-flex flex-column gap-24" id="<?php echo esc_attr( $accordion_id ); ?>">
						<?php foreach ( $items as $index => $item ) : ?>
							<?php
							$item_title = ! empty( $item['title'] ) ? $item['title'] : '';
							$item_text  = ! empty( $item['text'] ) ? $item['text'] : '';

							if ( ! $item_title && ! $item_text ) {
								continue;
							}

							$heading_id  = $accordion_id . '-heading-' . $index;
							$collapse_id = $accordion_id . '-collapse-' . $index;
							?>
							<div class="accordion-item">
								<h3 class="accordion-header" id="<?php echo esc_attr( $heading_id ); ?>">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr( $collapse_id ); ?>" aria-expanded="false" aria-controls="<?php echo esc_attr( $collapse_id ); ?>">
										<span class="accordion-item-icon">
											<svg class="i-sprite icon-16" aria-hidden="true" focusable="false">
												<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-16.svg' ) ); ?>#chevron_down"></use>
											</svg>
										</span>
										<?php if ( $item_title ) : ?>
											<span class="p-m fw-bolder c-body"><?php echo wp_kses_post( $item_title ); ?></span>
										<?php endif; ?>
									</button>
								</h3>
								<?php if ( $item_text ) : ?>
									<div id="<?php echo esc_attr( $collapse_id ); ?>" class="accordion-collapse collapse" aria-labelledby="<?php echo esc_attr( $heading_id ); ?>" data-bs-parent="#<?php echo esc_attr( $accordion_id ); ?>">
										<div class="accordion-body">
											<p class="p-m c-body"><?php echo wp_kses_post( $item_text ); ?></p>
										</div>
									</div>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
