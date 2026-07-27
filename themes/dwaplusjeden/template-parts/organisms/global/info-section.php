<?php
/**
 * Reusable info section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$has_acf = function_exists( 'get_field' );
$prefix  = ! empty( $args['field_prefix'] ) ? $args['field_prefix'] : 'info';

if ( $has_acf && false === get_field( $prefix . '_enabled' ) ) {
	return;
}

$heading = $has_acf ? get_field( $prefix . '_heading' ) : '';
$text    = $has_acf ? get_field( $prefix . '_text' ) : '';
$cards   = $has_acf ? get_field( $prefix . '_cards' ) : array();
$use_default_card_icons = is_page_template(
	array(
		'template-ofertadziedzinowa.php',
		'template-oferta-branzowa.php',
	)
);
?>

<section class="od-info pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="' . esc_attr( $prefix ) . '-heading"' : ''; ?>>
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-10 offset-lg-1  col-xxxl-8 offset-xxxl-2 ">
				<div class="d-flex flex-column gap-8 align-items-center">
					<?php if ( $heading ) : ?>
						<h2 id="<?php echo esc_attr( $prefix ); ?>-heading" class="h6 fw-bolder c-body text-center"><?php echo wp_kses_post( $heading ); ?></h2>
					<?php endif; ?>
					<?php if ( $text ) : ?>
						<p class="p-m text-center"><?php echo wp_kses_post( $text ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<?php if ( $cards ) : ?>
			<div class="row mt-48 mt-sm-56 mt-lg-64 mt-xxxl-86">
				<div class="col-12 offset-xxxl-1 col-xxxl-10">
					<div class="row r-gap-24 a-card-sequence" data-animate-start="top 90%" data-animate-batch-max="4">
						<?php foreach ( $cards as $card ) : ?>
							<?php
							$title = isset( $card['title'] ) ? $card['title'] : '';
							$body  = isset( $card['text'] ) ? $card['text'] : '';
							$icon  = ! $use_default_card_icons && isset( $card['icon'] ) ? $card['icon'] : 0;
							$body_id = wp_unique_id( $prefix . '-card-description-' );
							?>
							<?php if ( $title || $body ) : ?>
								<div class="col-sm-6 col-xl-3 a-card-item">
									<div class="od-info-card">
										<div class="od-info-card-wrapper">
											<div class="od-info-card-icon">
												<?php dwaplusjeden_image( $icon, 'thumbnail', 'checkbadge.svg', wp_strip_all_tags( $title ) ); ?>
											</div>
											<div class="d-flex flex-column gap-8">
												<?php if ( $title ) : ?>
													<h3 class="p-l fw-bolder c-white text-center"><?php echo wp_kses_post( $title ); ?></h3>
												<?php endif; ?>
												<?php if ( $body ) : ?>
													<div class="od-info-card-description" data-info-card-description>
														<div id="<?php echo esc_attr( $body_id ); ?>" class="od-info-card-description-content" data-info-card-description-content>
															<p class="p-s c-white text-center"><?php echo wp_kses_post( $body ); ?></p>
														</div>
														<button class="od-info-card-description-toggle" type="button" aria-expanded="false" aria-controls="<?php echo esc_attr( $body_id ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Rozwiń opis: %s', 'dwaplusjeden' ), wp_strip_all_tags( $title ) ) ); ?>" hidden data-info-card-description-toggle>
															<svg class="i-sprite icon-20 opacity-0" aria-hidden="true" focusable="false">
																<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-20.svg' ) ); ?>#chevron_down"></use>
															</svg>
														</button>
													</div>
												<?php endif; ?>
											</div>
											<div class="od-info-card-bottom"></div>
										</div>
									</div>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
