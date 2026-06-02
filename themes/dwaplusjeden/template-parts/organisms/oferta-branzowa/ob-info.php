<?php
/**
 * Offer industry info cards.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) || ! get_field( 'ob_info_enabled' ) ) {
	return;
}

$heading = get_field( 'ob_info_heading' );
$cards   = get_field( 'ob_info_cards' );
?>

<section class="od-info pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="ob-info-heading"' : ''; ?>>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="d-flex flex-column gap-8 align-items-center">
					<?php if ( $heading ) : ?>
						<h2 id="ob-info-heading" class="h6 fw-bolder c-body text-center"><?php echo esc_html( $heading ); ?></h2>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php if ( $cards ) : ?>
			<div class="row mt-48 mt-sm-56 mt-lg-64 mt-xxxl-86">
				<div class="col-12 offset-xxxl-1 col-xxxl-10">
					<div class="row r-gap-24 a-card-sequence" data-animate-start="top 90%" data-animate-batch-max="4">
						<?php foreach ( $cards as $card ) : ?>
							<div class="col-sm-6 col-xl-3 a-card-item">
								<div class="od-info-card">
									<div class="od-info-card-wrapper">
										<div class="od-info-card-icon">
											<?php dwaplusjeden_image( $card['icon'], 'thumbnail', 'checkbadge.svg', $card['title'] ); ?>
										</div>
										<div class="d-flex flex-column gap-8">
											<?php if ( $card['title'] ) : ?>
												<h3 class="p-l fw-bolder c-white text-center"><?php echo esc_html( $card['title'] ); ?></h3>
											<?php endif; ?>
											<?php if ( $card['text'] ) : ?>
												<p class="p-s c-white text-center"><?php echo esc_html( $card['text'] ); ?></p>
											<?php endif; ?>
										</div>
										<div class="od-info-card-bottom"></div>
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
