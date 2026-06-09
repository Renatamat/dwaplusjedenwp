<?php
/**
 * Contact page details and Contact Form 7 section.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'get_field' ) || false === get_field( 'contact_form_enabled' ) ) {
	return;
}

$section_heading = get_field( 'contact_form_details_heading' );
$form_heading    = get_field( 'contact_form_heading' );
$form_id         = (int) get_field( 'contact_form_cf7_form' );

$company_name     = get_field( 'contact_company_name' );
$company_email    = get_field( 'contact_company_email' );
$company_phone    = get_field( 'contact_company_phone' );
$company_hours    = get_field( 'contact_company_hours' );
$company_address  = get_field( 'contact_company_address' );
$company_krs      = get_field( 'contact_company_krs' );
$company_nip      = get_field( 'contact_company_nip' );
$company_regon    = get_field( 'contact_company_regon' );
$company_court    = get_field( 'contact_company_court' );
$contact_label    = get_field( 'contact_company_contact_label' );
$address_label    = get_field( 'contact_company_address_label' );
$contact_icon     = get_field( 'contact_details_icon' );
$address_icon     = get_field( 'contact_address_icon' );
$phone_href       = $company_phone ? preg_replace( '/[^0-9+]/', '', $company_phone ) : '';
$legal_parts      = array();
$render_icon      = static function ( $icon_id, $fallback_file, $alt = '' ) {
	if ( $icon_id ) {
		echo wp_get_attachment_image(
			$icon_id,
			'full',
			false,
			array(
				'alt'    => get_post_meta( $icon_id, '_wp_attachment_image_alt', true ) ?: $alt,
				'width'  => 48,
				'height' => 48,
				'style'  => 'width:48px;height:48px;display:block;flex-shrink:0;',
			)
		);
		return;
	}

	$fallback_path = get_template_directory() . '/_dev/source/images/' . ltrim( $fallback_file, '/' );

	if ( is_readable( $fallback_path ) ) {
		$svg = file_get_contents( $fallback_path );
		$svg = preg_replace( '/<svg\b([^>]*)\bwidth="[^"]*"/', '<svg$1width="48"', $svg, 1 );
		$svg = preg_replace( '/<svg\b([^>]*)\bheight="[^"]*"/', '<svg$1height="48"', $svg, 1 );
		$svg = preg_replace( '/<svg\b(?![^>]*\bstyle=)/', '<svg style="width:48px;height:48px;display:block;flex-shrink:0;"', $svg, 1 );

		echo $svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
};

if ( $company_krs ) {
	$legal_parts[] = 'KRS: ' . $company_krs;
}

if ( $company_nip ) {
	$legal_parts[] = 'NIP: ' . $company_nip;
}

if ( $company_regon ) {
	$legal_parts[] = 'REGON: ' . $company_regon;
}

if ( $company_court ) {
	$legal_parts[] = $company_court;
}



$form_shortcode = $form_id ? '[contact-form-7 id="' . $form_id . '"]' : '';
?>

<section class="contact pt-56 pb-56 pt-sm-64 pb-sm-64 pt-lg-96 pb-lg-96 pt-xxxl-132 pb-xxxl-132">
	<div class="container">
		<div class="row r-gap-48">
			<div class="offset-xxxl-1 col-lg-6 col-xxxl-4 order-2 order-lg-1">
				<div class="d-flex flex-column gap-32 gap-sm-40 gap-lg-48">
					<?php if ( $section_heading ) : ?>
						<span class="p-xl fw-bolder c-body"><?php echo wp_kses_post( $section_heading ); ?></span>
					<?php endif; ?>
					<div class="d-flex flex-column gap-24">
						<?php if ( $company_phone || $company_email || $company_hours || $contact_label ) : ?>
							<div class="d-flex gap-24 align-items-start">
								<div class="contact-item-icon a-slide-left" data-animate-delay="0.10">
									<?php $render_icon( $contact_icon, 'contacticon1.svg', wp_strip_all_tags( $contact_label ) ); ?>
								</div>
								<div class="d-flex flex-column gap-8">
									<?php if ( $contact_label ) : ?>
										<span class="p-m fw-bolder c-body"><?php echo wp_kses_post( $contact_label ); ?></span>
									<?php endif; ?>
									<?php if ( $company_phone ) : ?>
										<a href="tel:<?php echo esc_attr( $phone_href ); ?>" class="p-m c-body link-underline-rtl"><?php echo esc_html( $company_phone ); ?></a>
									<?php endif; ?>
									<?php if ( $company_email ) : ?>
										<a href="mailto:<?php echo esc_attr( antispambot( $company_email ) ); ?>" class="p-m c-body link-underline-rtl"><?php echo esc_html( antispambot( $company_email ) ); ?></a>
									<?php endif; ?>
									<?php if ( $company_hours ) : ?>
										<span class="p-xs c-body"><?php echo wp_kses_post( $company_hours ); ?></span>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( $company_address || $company_name || $legal_parts ) : ?>
							<div class="d-flex gap-24 align-items-start">
								<div class="contact-item-icon a-slide-left" data-animate-delay="0.16">
									<?php $render_icon( $address_icon, 'contacticon2.svg', wp_strip_all_tags( $address_label ) ); ?>
								</div>
								<div class="d-flex flex-column gap-8">
									<?php if ( $address_label ) : ?>
										<span class="p-m fw-bolder c-body"><?php echo wp_kses_post( $address_label ); ?></span>
									<?php endif; ?>
									<?php if ( $company_address ) : ?>
										<span><?php echo wp_kses_post( $company_address ); ?></span>
									<?php endif; ?>
									<div class="d-flex flex-column gap-8">
										<?php if ( $company_name ) : ?>
											<span class="p-m fw-bolder c-body"><?php echo esc_html( $company_name ); ?></span>
										<?php endif; ?>
										<?php if ( $company_krs || $company_nip || $company_regon ) : ?>
											<span class="p-m c-body">
												<?php if ( $company_krs ) : ?>
													KRS: <?php echo esc_html( $company_krs ); ?><br>
												<?php endif; ?>
												<?php if ( $company_nip ) : ?>
													NIP: <?php echo esc_html( $company_nip ); ?><br>
												<?php endif; ?>
												<?php if ( $company_regon ) : ?>
													REGON: <?php echo esc_html( $company_regon ); ?>
												<?php endif; ?>
											</span>
										<?php endif; ?>
										<?php if ( $company_court ) : ?>
											<span class="p-xs c-body">
												<?php echo wp_kses_post( $company_court ) ; ?>
											</span>
										<?php endif; ?>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<?php if ( $form_heading || $form_shortcode ) : ?>
				<div class="offset-xxxl-1 col-lg-6 col-xxxl-5 order-1 order-lg-2 a-fade-in-up">
					<div class="contact-form">
						<div class="d-flex flex-column gap-24">
							<?php if ( $form_heading ) : ?>
								<span class="p-xl fw-bolder c-body"><?php echo wp_kses_post( $form_heading ); ?></span>
							<?php endif; ?>
							<?php if ( $form_shortcode ) : ?>
								<?php echo do_shortcode( $form_shortcode ); ?>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
