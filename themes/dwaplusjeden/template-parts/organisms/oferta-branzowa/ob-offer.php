<?php
/**
 * Offer industry two-part offer.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) || ! get_field( 'ob_offer_enabled' ) ) {
	return;
}

$left_image  = get_field( 'ob_offer_left_image' );
$left_text   = get_field( 'ob_offer_left_text' );
$right_image = get_field( 'ob_offer_right_image' );
$right_text  = get_field( 'ob_offer_right_text' );
$link        = dwaplusjeden_get_acf_link( 'ob_offer_link', get_the_ID() );
?>

<section class="ob-offer pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="ob-offer-container a-ob-offer-sequence">
					<div class="ob-offer-item a-ob-offer-left">
						<?php dwaplusjeden_image( $left_image, 'full', 'offer1.jpg', $left_text ); ?>
						<?php if ( $left_text ) : ?>
							<span class="h6 fw-bolder c-body"><?php echo wp_kses_post( nl2br( esc_html( $left_text ) ) ); ?></span>
						<?php endif; ?>
					</div>
					<div class="ob-offer-item a-ob-offer-right">
						<?php dwaplusjeden_image( $right_image, 'full', 'offer2.jpg', $right_text ); ?>
						<?php if ( $right_text ) : ?>
							<span class="h6 fw-bolder c-white"><?php echo wp_kses_post( nl2br( esc_html( $right_text ) ) ); ?></span>
						<?php endif; ?>
					</div>
					<div class="ob-offer-plus a-ob-offer-plus" aria-hidden="true">
						<svg xmlns="http://www.w3.org/2000/svg" width="165" height="165" viewBox="0 0 165 165" fill="none">
							<path d="M58.4375 154.688C58.4375 157.423 59.524 160.046 61.458 161.98C63.3919 163.913 66.015 165 68.75 165H96.25C98.985 165 101.608 163.913 103.542 161.98C105.476 160.046 106.562 157.423 106.562 154.688V108.281C106.562 107.825 106.744 107.388 107.066 107.066C107.388 106.744 107.825 106.562 108.281 106.562H154.688C157.423 106.562 160.046 105.476 161.98 103.542C163.913 101.608 165 98.985 165 96.25V68.75C165 66.015 163.913 63.3919 161.98 61.458C160.046 59.524 157.423 58.4375 154.688 58.4375H108.281C107.825 58.4375 107.388 58.2564 107.066 57.9341C106.744 57.6118 106.562 57.1746 106.562 56.7188V10.3125C106.562 7.57746 105.476 4.95443 103.542 3.02046C101.608 1.08649 98.985 0 96.25 0L68.75 0C66.015 0 63.3919 1.08649 61.458 3.02046C59.524 4.95443 58.4375 7.57746 58.4375 10.3125V56.7188C58.4375 57.1746 58.2564 57.6118 57.9341 57.9341C57.6118 58.2564 57.1746 58.4375 56.7188 58.4375H10.3125C7.57746 58.4375 4.95443 59.524 3.02046 61.458C1.08649 63.3919 0 66.015 0 68.75L0 96.25C0 98.985 1.08649 101.608 3.02046 103.542C4.95443 105.476 7.57746 106.562 10.3125 106.562H56.7188C57.1746 106.562 57.6118 106.744 57.9341 107.066C58.2564 107.388 58.4375 107.825 58.4375 108.281V154.688Z" fill="#E62E2E"/>
						</svg>
					</div>
				</div>
			</div>
		</div>
		<?php if ( ! empty( $link['url'] ) ) : ?>
			<div class="row mt-32 mt-sm-40 mt-lg-48 mt-xxxl-64">
				<div class="col-md-6 col-lg-4 mx-auto">
					<a<?php dwaplusjeden_link_attrs( $link ); ?> class="c-btn c-btn-s c-btn-fill w-100">
						<span><?php echo esc_html( $link['title'] ?: $link['url'] ); ?></span>
					</a>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
