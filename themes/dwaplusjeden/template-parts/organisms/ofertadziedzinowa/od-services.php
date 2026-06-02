<?php
/**
 * Field offer services.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$has_acf = function_exists( 'get_field' );

if ( $has_acf && false === get_field( 'od_services_enabled' ) ) {
	return;
}

$heading = $has_acf ? get_field( 'od_services_heading' ) : '';
$text    = $has_acf ? get_field( 'od_services_text' ) : '';
$items   = $has_acf ? get_field( 'od_services_items' ) : array();
$link    = $has_acf ? dwaplusjeden_get_acf_link( 'od_services_link', get_the_ID() ) : array();
?>

<section class="od-services pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132"<?php echo $heading ? ' aria-labelledby="od-services-heading"' : ''; ?>>
	<div class="container">
		<div class="row">
			<div class="offset-xxxl-1 col-lg-5 col-xxxl-4">
				<div class="d-flex flex-column gap-24">
					<?php if ( $heading ) : ?>
						<h2 id="od-services-heading" class="h6 fw-bolder c-white a-slide-left" data-animate-delay="0.08"><?php echo wp_kses_post( $heading ); ?></h2>
					<?php endif; ?>
					<?php if ( $text ) : ?>
						<p class="p-m fw-bolder c-white a-slide-left" data-animate-delay="0.12"><?php echo wp_kses_post( $text ); ?></p>
					<?php endif; ?>
				</div>
			</div>
			<?php if ( $items ) : ?>
				<div class="offset-lg-1 col-lg-6 mt-32 mt-sm-40 mt-lg-0">
					<div class="d-flex flex-column gap-16 gap-lg-24">
						<?php foreach ( $items as $item ) : ?>
							<?php $item_text = isset( $item['text'] ) ? $item['text'] : ''; ?>
							<?php if ( $item_text ) : ?>
								<div class="od-services-item a-fade-in-up">
									<span class="p-m fw-bolder c-white"><?php echo wp_kses_post( $item_text ); ?></span>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<?php if ( ! empty( $link['url'] ) ) : ?>
			<div class="row mt-48 mt-sm-56 mt-lg-64 mt-xxxl-86">
				<div class="col-sm-10 col-lg-4 col-xxxl-3 mx-auto">
					<a<?php dwaplusjeden_link_attrs( $link ); ?> class="c-btn c-btn-s c-btn-fill w-100">
						<span><?php echo esc_html( $link['title'] ); ?></span>
					</a>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
