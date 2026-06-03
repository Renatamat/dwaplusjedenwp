<?php
/**
 * Registration page info section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) || false === get_field( 'rd_info_enabled' ) ) {
	return;
}

$heading = get_field( 'rd_info_heading' );
$cards   = get_field( 'rd_info_cards' );

if ( ! $heading && ! $cards ) {
	return;
}
?>

<section class="hp-info pt-64 pb-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="rd-info-heading"' : ''; ?>>
	<div class="container">
		<?php if ( $heading ) : ?>
			<div class="row">
				<div class="col-12">
					<div class="d-flex flex-column gap-8 align-items-center">
						<h2 id="rd-info-heading" class="h6 fw-bolder c-body text-center"><?php echo wp_kses_post( $heading ); ?></h2>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $cards ) : ?>
			<div class="row pt-48 pt-sm-56 pt-lg-64 pt-xxxl-86">
				<div class="col-12 offset-xxxl-1 col-xxxl-10">
					<div class="row r-gap-24 a-card-sequence" data-animate-start="top 90%" data-animate-batch-max="4">
						<?php foreach ( $cards as $card ) : ?>
							<?php
							$card_title = ! empty( $card['title'] ) ? $card['title'] : '';
							$card_text  = ! empty( $card['text'] ) ? $card['text'] : '';

							if ( ! $card_title && ! $card_text ) {
								continue;
							}
							?>
							<div class="col-sm-6 col-lg-4 a-card-item">
								<div class="hp-info-card">
									<div class="hp-info-card-wrapper">
										<div class="d-flex flex-column gap-16 gap-lg-24">
											<div class="hp-info-card-icon">
												<img src="/wp-content/uploads/2026/06/checkbadge.svg" alt="">
											</div>
											<div class="d-flex flex-column gap-8">
												<?php if ( $card_title ) : ?>
													<h3 class="p-l fw-bolder c-white"><?php echo wp_kses_post( $card_title ); ?></h3>
												<?php endif; ?>
												<?php if ( $card_text ) : ?>
													<p class="p-s c-white"><?php echo wp_kses_post( $card_text ); ?></p>
												<?php endif; ?>
											</div>
										</div>
										<div class="hp-info-card-bottom"></div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
