<?php
/**
 * Blog single static CTA section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$contact_url = home_url( '/kontakt/' );
$pricing_url = home_url( '/cennik/' );
?>

<section class="blog-single-cta pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="d-flex flex-column gap-24 justify-content-center">
					<span class="h5 fw-bolder c-white text-center"><?php esc_html_e( 'Potrzebujesz pomocy?', 'dwaplusjeden' ); ?></span>
					<p class="p-l fw-bolder c-white text-center"><?php esc_html_e( 'Umów się na bezpłatną konsultację i dowiedz się, jak możemy pomóc Twojej firmie', 'dwaplusjeden' ); ?></p>
				</div>
			</div>
		</div>
		<div class="row mt-32">
			<div class="col-sm-10 col-md-8 col-xl-6 col-xxl-5 mx-auto">
				<div class="d-flex flex-column flex-lg-row gap-16 gap-lg-24">
					<a href="<?php echo esc_url( $contact_url ); ?>" class="c-btn c-btn-s c-btn-fill w-100">
						<span><?php esc_html_e( 'Skontaktuj się z nami', 'dwaplusjeden' ); ?></span>
					</a>
					<a href="<?php echo esc_url( $pricing_url ); ?>" class="c-btn c-btn-s c-btn-outline --white w-100">
						<span><?php esc_html_e( 'Zobacz cennik', 'dwaplusjeden' ); ?></span>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>
