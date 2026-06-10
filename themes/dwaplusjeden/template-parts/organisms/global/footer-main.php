<?php
/**
 * Footer main content.
 *
 * @package dwaplusjeden
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$company_name             = function_exists( 'get_field' ) ? get_field( 'company_name', 'option' ) : '';
$company_email            = function_exists( 'get_field' ) ? get_field( 'company_email', 'option' ) : '';
$company_phone            = function_exists( 'get_field' ) ? get_field( 'company_phone', 'option' ) : '';
$footer_logo_id           = function_exists( 'get_field' ) ? get_field( 'footer_logo', 'option' ) : '';
$footer_contact_label     = function_exists( 'get_field' ) ? get_field( 'footer_contact_label', 'option' ) : '';
$footer_contact_link      = dwaplusjeden_get_acf_link( 'footer_contact_link' );
$newsletter_heading       = function_exists( 'get_field' ) ? get_field( 'footer_newsletter_heading', 'option' ) : '';
$newsletter_text          = function_exists( 'get_field' ) ? get_field( 'footer_newsletter_text', 'option' ) : '';
$newsletter_shortcode     = function_exists( 'get_field' ) ? get_field( 'footer_newsletter_shortcode', 'option' ) : '';
$accounting_title         = function_exists( 'get_field' ) ? get_field( 'footer_accounting_title', 'option' ) : '';
$industries_title         = function_exists( 'get_field' ) ? get_field( 'footer_industries_title', 'option' ) : '';
$business_support_title   = function_exists( 'get_field' ) ? get_field( 'footer_business_support_title', 'option' ) : '';
$registration_title       = function_exists( 'get_field' ) ? get_field( 'footer_company_registration_title', 'option' ) : '';
$useful_links_title       = function_exists( 'get_field' ) ? get_field( 'footer_useful_links_title', 'option' ) : '';
$login_text               = function_exists( 'get_field' ) ? get_field( 'footer_login_text', 'option' ) : '';
$login_button_label       = function_exists( 'get_field' ) ? get_field( 'footer_login_button_label', 'option' ) : '';
$login_url                = function_exists( 'get_field' ) ? get_field( 'general_login_url', 'option' ) : '';
$copyright                = function_exists( 'get_field' ) ? get_field( 'footer_copyright', 'option' ) : '';
$privacy_link             = dwaplusjeden_get_acf_link( 'footer_privacy_link' );
$terms_link               = dwaplusjeden_get_acf_link( 'footer_terms_link' );
$credits_text             = function_exists( 'get_field' ) ? get_field( 'footer_credits_text', 'option' ) : '';
$credits_logo_id          = function_exists( 'get_field' ) ? get_field( 'footer_credits_logo', 'option' ) : '';
$credits_link             = dwaplusjeden_get_acf_link( 'footer_credits_link' );
$footer_logo_alt          = $footer_logo_id ? get_post_meta( $footer_logo_id, '_wp_attachment_image_alt', true ) : '';
$credits_logo_alt         = $credits_logo_id ? get_post_meta( $credits_logo_id, '_wp_attachment_image_alt', true ) : '';
$login_url                = dwaplusjeden_translate_url( $login_url );
$footer_menu_columns      = array(
	array(
		'title'    => $accounting_title,
		'location' => 'footer-accounting',
	),
	array(
		'title'    => $industries_title,
		'location' => 'footer-industries',
	),
	array(
		'title'    => $business_support_title,
		'location' => 'footer-business-support',
	),
	array(
		'title'    => $registration_title,
		'location' => 'footer-company-registration',
	),
);
?>

<div class="container mt-32 mt-lg-48">
	<div class="row r-gap-24">
		<div class="col-md-5 col-lg-3 order-2 order-md-1">
			<div class="d-flex flex-column gap-32">
				<?php if ( $footer_logo_id ) : ?>
					<div class="footer-logo">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php echo wp_get_attachment_image( $footer_logo_id, 'full', false, array( 'alt' => $footer_logo_alt ) ); ?>
						</a>
					</div>
				<?php endif; ?>

				<div class="d-flex flex-column gap-24">
					<?php if ( $company_name ) : ?>
						<span class="p-m fw-bolder c-white"><?php echo esc_html( $company_name ); ?></span>
					<?php endif; ?>

					<?php if ( $company_email || $company_phone || ! empty( $footer_contact_link['url'] ) ) : ?>
						<div class="d-flex flex-column gap-16 c-white">
							<?php if ( $footer_contact_label ) : ?>
								<span class="p-s fw-bolder"><?php echo esc_html( $footer_contact_label ); ?></span>
							<?php endif; ?>

							<?php if ( $company_email || $company_phone ) : ?>
								<div class="d-flex flex-column gap-8">
									<?php if ( $company_email ) : ?>
										<a href="mailto:<?php echo esc_attr( antispambot( $company_email ) ); ?>" class="p-s c-white link-underline-rtl"><?php echo esc_html( antispambot( $company_email ) ); ?></a>
									<?php endif; ?>

									<?php if ( $company_phone ) : ?>
										<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $company_phone ) ); ?>" class="p-s c-white link-underline-rtl"><?php echo esc_html( $company_phone ); ?></a>
									<?php endif; ?>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $footer_contact_link['url'] ) ) : ?>
								<a<?php dwaplusjeden_link_attrs( $footer_contact_link ); ?> class="c-btn c-btn-s c-btn-fill footer-btn-contact">
									<span><?php echo esc_html( $footer_contact_link['title'] ?: $footer_contact_label ); ?></span>
								</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<?php if ( $newsletter_heading || $newsletter_text || $newsletter_shortcode ) : ?>
			<div class="offset-lg-3 col-md-7 col-lg-6 order-1 order-md-2">
				<div class="newsletter-card">
					<div class="newsletter-card-wrapper">
						<?php if ( $newsletter_heading || $newsletter_text ) : ?>
							<div class="d-flex flex-column gap-8">
								<?php if ( $newsletter_heading ) : ?>
									<span class="p-m fw-bolder c-white"><?php echo esc_html( $newsletter_heading ); ?></span>
								<?php endif; ?>

								<?php if ( $newsletter_text ) : ?>
									<p class="p-s c-white"><?php echo esc_html( $newsletter_text ); ?></p>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php if ( $newsletter_shortcode ) : ?>
							<?php echo do_shortcode( $newsletter_shortcode ); ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>

	<div class="row r-gap-24 mt-24 mt-sm-56 mt-lg-96">
		<?php foreach ( $footer_menu_columns as $column ) : ?>
			<?php if ( $column['title'] || dwaplusjeden_get_menu_items_by_location( $column['location'] ) ) : ?>
				<div class="col-sm-6 col-lg-3">
					<div class="d-flex flex-column gap-16">
						<?php if ( $column['title'] ) : ?>
							<span class="p-m fw-bolder c-white"><?php echo esc_html( $column['title'] ); ?></span>
						<?php endif; ?>

						<?php dwaplusjeden_footer_menu( $column['location'] ); ?>
					</div>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>

	<div class="row mt-24 mt-lg-48 mb-32 mb-lg-48">
		<?php if ( $useful_links_title || dwaplusjeden_get_menu_items_by_location( 'footer-useful-links' ) ) : ?>
			<div class="col-lg-6">
				<div class="d-flex flex-column gap-16">
					<?php if ( $useful_links_title ) : ?>
						<span class="p-m fw-bolder c-white"><?php echo esc_html( $useful_links_title ); ?></span>
					<?php endif; ?>

					<?php dwaplusjeden_footer_menu( 'footer-useful-links', 'footer-links-grid' ); ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $login_text || $login_url ) : ?>
			<div class="col-lg-6">
				<div class="footer-login">
					<?php if ( $login_text ) : ?>
						<span class="p-m fw-bolder c-body"><?php echo esc_html( $login_text ); ?></span>
					<?php endif; ?>

					<?php if ( $login_url ) : ?>
						<a href="<?php echo esc_url( $login_url ); ?>" class="c-btn c-btn-s c-btn-fill footer-btn-contact">
							<span><?php echo esc_html( $login_button_label ?: esc_html__( 'Logowanie', 'dwaplusjeden' ) ); ?></span>
						</a>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>

	<div class="footer-copyright">
		<div class="d-flex flex-column flex-sm-row align-items-center gap-20">
			<?php if ( $copyright ) : ?>
				<span class="p-s c-white"><?php echo esc_html( $copyright ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $privacy_link['url'] ) ) : ?>
				<a<?php dwaplusjeden_link_attrs( $privacy_link ); ?> class="p-s c-white link-underline-rtl"><?php echo esc_html( $privacy_link['title'] ?: $privacy_link['url'] ); ?></a>
			<?php endif; ?>

			<?php if ( ! empty( $terms_link['url'] ) ) : ?>
				<a<?php dwaplusjeden_link_attrs( $terms_link ); ?> class="p-s c-white link-underline-rtl"><?php echo esc_html( $terms_link['title'] ?: $terms_link['url'] ); ?></a>
			<?php endif; ?>
		</div>

		<?php if ( $credits_text || $credits_logo_id || ! empty( $credits_link['url'] ) ) : ?>
			<div class="d-flex flex-column flex-sm-row align-items-center gap-16">
				<?php if ( $credits_text ) : ?>
					<span class="p-s c-white"><?php echo esc_html( $credits_text ); ?></span>
				<?php endif; ?>

				<?php if ( $credits_logo_id ) : ?>
					<div>
						<?php echo wp_get_attachment_image( $credits_logo_id, 'full', false, array( 'alt' => $credits_logo_alt ) ); ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $credits_link['url'] ) ) : ?>
					<span class="p-s c-white"><a<?php dwaplusjeden_link_attrs( $credits_link ); ?> class="p-s c-white link-underline-rtl"><?php echo esc_html( $credits_link['title'] ?: $credits_link['url'] ); ?></a></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</div>
