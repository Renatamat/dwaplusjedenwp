<?php
/**
 * Homepage services.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) || ! get_field( 'homepage_services_enabled' ) ) {
	return;
}

$eyebrow  = get_field( 'homepage_services_eyebrow' );
$heading  = get_field( 'homepage_services_heading' );
$text     = get_field( 'homepage_services_text' );
$services = get_field( 'homepage_services_items' );
?>

<section class="hp-services pt-56 pb-56 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="homepage-services-heading"' : ''; ?>>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="d-flex flex-column align-items-center gap-20">
					<?php if ( $eyebrow ) : ?>
						<span class="subtitle p-s fw-bolder c-white"><?php echo esc_html( $eyebrow ); ?></span>
					<?php endif; ?>
					<div class="d-flex flex-column gap-8 align-items-center">
						<?php if ( $heading ) : ?>
							<h2 id="homepage-services-heading" class="h5 fw-bolder c-body text-center"><?php echo esc_html( $heading ); ?></h2>
						<?php endif; ?>
						<?php if ( $text ) : ?>
							<p class="p-m c-black text-center"><?php echo esc_html( $text ); ?></p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<?php if ( $services ) : ?>
			<div class="row pt-48 pt-lg-64">
				<div class="col-12 offset-xxxl-1 col-xxxl-10">
					<div class="row r-gap-24 a-card-sequence" data-animate-start="top 90%">
						<?php foreach ( $services as $service ) : ?>
							<?php $link = dwaplusjeden_get_relation_or_link( $service['related_page'], $service['link'] ); ?>
							<div class="col-sm-6 col-lg-4 a-card-item">
								<?php echo $link ? '<a' : '<div'; ?><?php $link ? dwaplusjeden_link_attrs( $link ) : null; ?> class="service-card">
									<div class="service-card-wrapper">
										<div class="service-card-img">
											<?php dwaplusjeden_image( $service['icon'], 'thumbnail', 'service1.svg', $service['title'] ); ?>
										</div>
										<div class="d-flex flex-column gap-20">
											<div class="d-flex flex-column gap-8 service-card-content">
												<?php if ( $service['title'] ) : ?>
													<h3 class="p-m fw-bolder c-body"><?php echo esc_html( $service['title'] ); ?></h3>
												<?php endif; ?>
												<?php if ( $service['text'] ) : ?>
													<p class="p-s"><?php echo esc_html( $service['text'] ); ?></p>
												<?php endif; ?>
											</div>
											<div class="c-btn c-btn-s c-btn-text w-100 justify-content-between service-card-button">
												<span class="p-0"><?php echo esc_html( $service['button_label'] ?: __( 'Sprawdź', 'dwaplusjeden' ) ); ?></span>
												<svg class="i-sprite icon-16" aria-hidden="true" focusable="false">
													<use href="<?php echo esc_url( dwaplusjeden_get_sprite_url( 'icons-16.svg' ) ); ?>#arrow_right_2"></use>
												</svg>
											</div>
										</div>
									</div>
								<?php echo $link ? '</a>' : '</div>'; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
